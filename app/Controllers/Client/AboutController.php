<?php

namespace App\Controllers\Client;

use App\Controller;

// use App\Models\Product;


class AboutController extends Controller{
    public function index(){
        $heading1 = 'Trang giới thiệu';
        $subHeading1 = '********************';
        return view('client.about', compact('heading1', 'subHeading1'));
    }
}