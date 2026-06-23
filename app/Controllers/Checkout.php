<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\OrderModel;

class Checkout extends BaseController
{
    private CartModel  $cartModel;
    private OrderModel $orderModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->cartModel  = new CartModel();
        $this->orderModel = new OrderModel();
    }

    private function sessionId(): string
    {
        return session()->get('__cart_sid') ?? '';
    }

    private function userId(): int
    {
        return (int)auth()->user()->id;
    }

    public function index(): string
    {
        $user  = auth()->user();
        $items = $this->cartModel->getCartItems($this->sessionId(), $this->userId());

        if (empty($items)) {
            return redirect()->to(site_url('cart'))->with('info', 'Your cart is empty.');
        }

        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));

        // Get stored address from session or user profile
        $savedAddress = session()->get('checkout_address') ?? [];

        return view('public/checkout', [
            'title'        => 'Checkout — ' . brand_setting('site_name'),
            'items'        => $items,
            'subtotal'     => $subtotal,
            'user'         => $user,
            'savedAddress' => $savedAddress,
        ]);
    }

    public function confirm()
    {
        $user  = auth()->user();
        $items = $this->cartModel->getCartItems($this->sessionId(), $this->userId());

        if (empty($items)) {
            return redirect()->to(site_url('cart'));
        }

        $rules = [
            'customer_name'  => 'required|min_length[2]|max_length[120]',
            'customer_email' => 'required|valid_email',
            'customer_phone' => 'required|min_length[10]',
            'address_line1'  => 'required|min_length[5]',
            'city'           => 'required',
            'state'          => 'required',
            'pincode'        => 'required|min_length[5]|max_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));

        // Save address to session for next time
        $addressData = $this->request->getPost([
            'customer_name', 'customer_email', 'customer_phone',
            'address_line1', 'address_line2', 'city', 'state', 'pincode',
        ]);
        session()->set('checkout_address', $addressData);

        $orderData = array_merge($addressData, [
            'order_number' => $this->orderModel->generateOrderNumber(),
            'user_id'      => $this->userId(),
            'subtotal'     => $subtotal,
            'total'        => $subtotal,
            'status'       => 'pending',
            'notes'        => $this->request->getPost('notes'),
        ]);

        $orderItems = array_map(fn($item) => [
            'product_id' => $item['product_id'],
            'title'      => $item['title'],
            'sku'        => $item['sku'] ?? null,
            'price'      => $item['price'],
            'quantity'   => $item['quantity'],
        ], $items);

        $orderId = $this->orderModel->placeOrder($orderData, $orderItems);

        // Clear cart after order
        $this->cartModel->clearCart($this->sessionId(), $this->userId());

        $order = $this->orderModel->find($orderId);

        return redirect()->to(site_url('checkout/success/' . $order['order_number']))
            ->with('order_placed', true);
    }

    public function success(string $orderNumber): string
    {
        if (!session()->get('order_placed')) {
            return redirect()->to(site_url('shop'));
        }

        $db  = \Config\Database::connect();
        $row = $db->table('orders')->where('order_number', $orderNumber)->get()->getRow();
        $order = $row ? $this->orderModel->getWithItems((int)$row->id) : null;

        return view('public/order_success', [
            'title' => 'Order Confirmed — ' . brand_setting('site_name'),
            'order' => $order,
        ]);
    }
}
