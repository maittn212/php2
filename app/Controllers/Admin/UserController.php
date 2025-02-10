<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\User;

class UserController extends Controller{
    private $user;
    public function __construct(){
        $this->user = new User();
    }   
    public function testBaseModel(){
        echo '<pre>';
        // print_r($this->user);
        // $data = $this->user->paginate( $_GET['page'] ?? 1,2);

        // tìm dl theo id
        // $data = $this->user->find(4);
        // print_r($data);

        // $data = $this->user->findAll();
        // $data = $this->user->count();

        // Sửa dữ liệu
        // $this->user->update(4,['name' => 'XYZZZXYZZZ']);
        // $data = $this->user->find(4);
        // print_r($data);

        // Xóa
        // $data = $this->user->delete(1);
        // print_r($data);



        // Thêm dữ liệu
        // $newUserId = $this->user->insert([
        //     'name' => 'Nguyen van a',
        //     'email' => 'abc@gmail.com',
        //     'password'=> password_hash('12345', PASSWORD_DEFAULT),
        //     'type' => 'client'
        // ]);

        // echo $newUserId;
    }

    public function index(){
        $title = '<i>Trang danh sách</i>';
        $data = $this->user->findAll();
        
        return view(
            'admin.users.index',
            compact('title', 'data')

        );
    }

    public function testUploadFile(){
        try{
          $pathFile =  $this->uploadFile($_FILES['avatar'], 'users');
        //   echo $pathFile;die();
            $_SESSION['msg'] = 'Upload file thành công';
        }catch(\Throwable $th){
            $this->logError($th->getMessage());

            $_SESSION['msg'] = 'Upload file thất bại';
        }
        header('Location: /admin/users');
        exit;
    }
}