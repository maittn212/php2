<?php

namespace App\Controllers\Client;

use App\Controller;

// use App\Models\Product;


class HomeController extends Controller{
    public function index(){
        $heading1 = 'Trang chủ';
        $subHeading1 = '********************';
        return view('client.home', compact('heading1', 'subHeading1'));
    }
}