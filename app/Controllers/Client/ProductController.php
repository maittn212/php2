<?php

namespace App\Controllers\Client;

use App\Controller;
use App\Models\Category;
use App\Models\Product;


class ProductController extends Controller{
    private Product $product;
    private Category $category;
    public function __construct(){
        $this->product = new Product();
        $this->category = new Category();

    }
    public function show($id){
        $heading1 = 'Trang chi tiết';
        $subHeading1 = '********************';
        $product = $this->product->find($id);
        if(empty($product) || $product['p_is_show_home'] == 00){
            redirect404();
        }
        return view('client.show', compact('heading1', 'subHeading1', 'product'));
    }
}