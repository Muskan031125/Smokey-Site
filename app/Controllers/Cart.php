<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;

class Cart extends BaseController
{
    private CartModel $cartModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->cartModel = new CartModel();
    }

    private function sessionId(): string
    {
        return session_id() ?: session()->get('__cart_sid') ?? $this->generateSid();
    }

    private function generateSid(): string
    {
        $sid = bin2hex(random_bytes(16));
        session()->set('__cart_sid', $sid);
        return $sid;
    }

    private function userId(): ?int
    {
        return auth()->loggedIn() ? (int)auth()->user()->id : null;
    }

    public function index(): string
    {
        $items = $this->cartModel->getCartItems($this->sessionId(), $this->userId());
        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));

        return view('public/cart', [
            'title'    => 'Your Cart — ' . brand_setting('site_name'),
            'items'    => $items,
            'subtotal' => $subtotal,
        ]);
    }

    public function add(): \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface
    {
        $productId = (int)$this->request->getPost('product_id');
        $qty       = max(1, (int)($this->request->getPost('quantity') ?? 1));

        $product = (new ProductModel())->find($productId);
        if (!$product || !$product['is_active']) {
            return $this->jsonOrRedirect(['error' => 'Product not found'], 'shop');
        }

        $this->cartModel->addOrUpdate($this->sessionId(), $productId, $qty, $this->userId());

        if ($this->request->isAJAX()) {
            $count = $this->cartModel->countItems($this->sessionId(), $this->userId());
            return $this->response->setJSON(['success' => true, 'count' => $count, 'message' => 'Added to cart']);
        }

        return redirect()->to(site_url('cart'))->with('success', '"' . $product['title'] . '" added to cart.');
    }

    public function update(): \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface
    {
        $productId = (int)$this->request->getPost('product_id');
        $qty       = (int)$this->request->getPost('quantity');

        $this->cartModel->setQuantity($this->sessionId(), $productId, $qty);

        if ($this->request->isAJAX()) {
            $items    = $this->cartModel->getCartItems($this->sessionId(), $this->userId());
            $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
            $count    = array_sum(array_column($items, 'quantity'));
            return $this->response->setJSON([
                'success'  => true,
                'subtotal' => $subtotal,
                'count'    => $count,
            ]);
        }

        return redirect()->to(site_url('cart'));
    }

    public function remove(): \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface
    {
        $productId = (int)$this->request->getPost('product_id');
        $this->cartModel->removeItem($this->sessionId(), $productId);

        if ($this->request->isAJAX()) {
            $items    = $this->cartModel->getCartItems($this->sessionId(), $this->userId());
            $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
            $count    = array_sum(array_column($items, 'quantity'));
            return $this->response->setJSON(['success' => true, 'subtotal' => $subtotal, 'count' => $count]);
        }

        return redirect()->to(site_url('cart'));
    }

    public function clear(): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->cartModel->clearCart($this->sessionId(), $this->userId());
        return redirect()->to(site_url('cart'));
    }

    public function count(): \CodeIgniter\HTTP\ResponseInterface
    {
        $count = $this->cartModel->countItems($this->sessionId(), $this->userId());
        return $this->response->setJSON(['count' => $count]);
    }

    private function jsonOrRedirect(array $data, string $fallbackRoute): \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface
    {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data)->setStatusCode(400);
        }
        return redirect()->to(site_url($fallbackRoute));
    }
}
