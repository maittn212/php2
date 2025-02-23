<?php

namespace App\Controllers\Client;

use App\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;


class HomeController extends Controller{
    private Product $product;
    private Banner $banner;
    public function __construct(){
        $this->product = new Product();
        $this->banner = new Banner();
    }
    public function index(){
        $heading1 = 'Trang chủ';
        $subHeading1 = '********************';
        $data = $this->product->findAll();
        $listBanner = $this->banner->findAll();

        $visivleProducts = array_filter($data, function($product){
            return $product['is_show_home'] == 1;
        });
        $visibleBanner = array_filter($listBanner, function($banner){
            return $banner['is_active'] == 1;
        });
        
        // debug($visibleBanner);


       return view('client.home', compact('heading1', 'subHeading1', 'visivleProducts', 'visibleBanner'));
    }
}