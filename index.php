<?php
session_start();
require 'vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();
require 'routers/index.php';


// use Rakit\Validation\Validator;

// $validator = new Validator;

// $data = [
//     'name' =>'mai',
//     'email' =>'mai@gmail.com'
// ];
// // make it
// $validation = $validator->make($data, [
//     'name'                  => 'required',
//     'email'                 => 'required|email',

// ]);
// // then validate
// $validation->validate();

// if ($validation->fails()) {
//     // handling errors
//     $errors = $validation->errors();
//     echo "<pre>";
//     print_r($errors->firstOfAll());
//     echo "</pre>";
//     exit;
// } else {
//     // validation passes
//     echo "Success!";
// }
