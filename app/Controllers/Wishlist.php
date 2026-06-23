<?php

namespace App\Controllers;

use App\Models\WishlistModel;

class Wishlist extends BaseController
{
    private WishlistModel $model;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->model = new WishlistModel();
    }

    private function sid(): string { return session()->get('__cart_sid') ?? ''; }
    private function uid(): ?int { return auth()->loggedIn() ? (int)auth()->user()->id : null; }

    public function index(): string
    {
        $items = $this->model->getItems($this->sid(), $this->uid());
        return view('public/wishlist', [
            'title' => 'Wishlist — ' . brand_setting('site_name'),
            'items' => $items,
        ]);
    }

    public function toggle(): \CodeIgniter\HTTP\ResponseInterface
    {
        $productId = (int)$this->request->getPost('product_id');
        $added     = $this->model->toggle($productId, $this->sid(), $this->uid());
        $count     = count($this->model->getProductIds($this->sid(), $this->uid()));

        return $this->response->setJSON([
            'success' => true,
            'added'   => $added,
            'count'   => $count,
            'message' => $added ? 'Added to wishlist' : 'Removed from wishlist',
        ]);
    }
}
