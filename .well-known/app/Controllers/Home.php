<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\BlogModel;
use App\Models\WishlistModel;

class Home extends BaseController
{
    public function index(): string
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();
        $blogModel     = new BlogModel();
        $wModel        = new WishlistModel();

        $sid = session()->get('__cart_sid') ?? '';
        $uid = auth()->loggedIn() ? (int)auth()->user()->id : null;

        $db              = \Config\Database::connect();
        $banners         = $db->table('homepage_banners')->where('is_active', 1)->orderBy('sort_order', 'ASC')->get()->getResultArray();
        $newArrivals     = $productModel->listPublic(['flag' => 'new_arrival'], 8, 0);
        $bestSellers     = $productModel->listPublic(['flag' => 'best_seller'], 8, 0);
        $featuredCategories = $categoryModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->limit(8)->findAll();
        $foundersPick    = $productModel->listPublic(['flag' => 'featured'], 4, 0);
        $recentPosts     = $blogModel->getPublished(3);
        $pressMentions   = $db->table('press_mentions')->where('is_active', 1)->orderBy('sort_order', 'ASC')->get()->getResultArray();
        $wishlistedIds   = $wModel->getProductIds($sid, $uid);

        // Bar essentials collections
        $barCollections = [];
        foreach (['Whiskey Essentials' => 'whi-glasses', 'Cocktail Essentials' => 'cocktail-glass', 'Wine Essentials' => 'wine-glasses', 'Bar Accessories' => 'bar-accessories'] as $name => $slug) {
            $cat = $categoryModel->where('slug', $slug)->where('is_active', 1)->first();
            if ($cat) {
                $count = $productModel->countPublic(['category_id' => $cat['id']]);
                $barCollections[] = array_merge($cat, ['display_name' => $name, 'count' => $count]);
            }
        }

        return view('public/home', [
            'title'              => brand_setting('brand_name', 'Smokey Cocktail') . ' — ' . brand_setting('brand_tagline', "Let's Party"),
            'banners'            => $banners,
            'newArrivals'        => $newArrivals,
            'bestSellers'        => $bestSellers,
            'featuredCategories' => $featuredCategories,
            'foundersPick'       => $foundersPick,
            'recentPosts'        => $recentPosts,
            'pressMentions'      => $pressMentions,
            'barCollections'     => $barCollections,
            'wishlistedIds'      => $wishlistedIds,
        ]);
    }
}
