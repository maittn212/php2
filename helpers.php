<?php

use eftec\bladeone\BladeOne;

if(!function_exists('view')){
    function view($view, $data=[]){
        $views = __DIR__ . '/views';
        $cache = __DIR__ . '/storage/compiles';
    
        $blade = new BladeOne($views,$cache,BladeOne::MODE_DEBUG); // MODE_DEBUG allows to pinpoint troubles.
        echo $blade->run($view, $data); // it calls /views/hello.blade.php
    }
}
if(!function_exists('file_url')){
    function file_url($path){
        if(!file_exists($path)){
            return null;
        }
        return $_ENV['APP_URL'] . $path;
    }
}

if(!function_exists('debug')){
    function debug(...$data){
        echo '<pre>';
        print_r($data);
        die();
    }
}
if(!function_exists('slug')){
    function slug($string, $seperator = '-'){
        // Chuyển đổi sang chữ thường
        $string = mb_strtolower($string, 'UTF-8');

        // Thay thế các ký tự đặc biệt và dấu tiếng việt
        

    }
}