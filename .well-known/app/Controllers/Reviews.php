<?php

namespace App\Controllers;

use App\Models\ReviewModel;

class Reviews extends BaseController
{
    public function submit(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'product_id' => 'required|is_natural_no_zero',
            'name'       => 'required|min_length[2]|max_length[100]',
            'rating'     => 'required|integer|greater_than[0]|less_than[6]',
            'body'       => 'permit_empty|max_length[2000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('review_errors', $this->validator->getErrors());
        }

        $model = new ReviewModel();
        $model->insert([
            'product_id'  => (int)$this->request->getPost('product_id'),
            'user_id'     => auth()->loggedIn() ? (int)auth()->user()->id : null,
            'name'        => $this->request->getPost('name'),
            'email'       => $this->request->getPost('email'),
            'rating'      => (int)$this->request->getPost('rating'),
            'title'       => $this->request->getPost('title'),
            'body'        => $this->request->getPost('body'),
            'is_approved' => 0,
        ]);

        return redirect()->back()->with('success', 'Thank you! Your review has been submitted and will appear after approval.');
    }
}
