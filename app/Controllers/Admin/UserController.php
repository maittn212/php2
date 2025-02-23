<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\User;
use Rakit\Validation\Validator;

class UserController extends Controller{
    private User $user;
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
        $title = 'Danh sách người dùng';
        $data = $this->user->findAll();
        // debug($data);
        
        return view(
            'admin.users.index',
            compact('title', 'data')

        );
    }
    public function show($id){
        $user = $this->user->find($id);
        // debug($user);
        if(empty($user)){
            redirect404();
        }
        $title = 'Chi tiết người dùng';
        return view('admin.users.show', compact('user', 'title'));
    }
    public function delete($id){
        $user = $this->user->find($id);
        if(empty($user)){
            redirect404();
        }
        $this->user->delete($id);

        if($user['avatar'] && file_exists($user['avatar'])){
            unlink($user['avatar']);
        }

        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Thao tác thành công';

        redirect('/admin/users');
    }
    public function create(){
        $title = 'Thêm mới người dùng';
        return view('admin.users.create', compact('title'));
    }
    public function store(){
        try {
            $data = $_POST + $_FILES;
            // validate
            $validator = new Validator;

            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name' => 'required|max:50',
                    'email' => [
                        'required',
                        'email',
                        function ($value){
                            $flag = (new User)->checkExistsEmailForCreate($value);
                            if($flag){
                                return ":attribute has existed";
                            }
                        }
                    ],
                    'password' => 'required|min:6|max:30',
                    'confirm_password' => 'required|same:password',
                    'avatar' => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'type' => [$validator('in',['admin','client'])],
                ]
                );

                if(!empty($errors)){
                    $_SESSION['status'] = false;
                    $_SESSION['msg'] = 'Thao tác không thành công';
                    $_SESSION['data'] = $_POST;
                    $_SESSION['errors'] = $errors;

                    redirect('/admin/users/create');
                }else{
                    $_SESSION['data'] = null;
                }

                // upload file
                if(is_upload('avatar')){
                    $data['avatar'] = $this->uploadFile($data['avatar'],'users');
                }else{
                    $data['avatar'] = null;
                }

                // điều chỉnh dl
                unset($data['confirm_password']);
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // insert
                $this->user->insert($data);
                $_SESSION['status'] = true;
                $_SESSION['msg'] = 'Thao tác thành công';

                redirect('/admin/users');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;
            redirect('/admin/users/create');

        }
    }

    public function edit($id){
        $user = $this->user->find($id);
        // debug($user);
        if(empty($user)){
            redirect404();
        }
        $title = 'Cập nhật người dùng';
        return view('admin.users.edit', compact('user','title')); 
    }

    public function update($id){
        // var_dump($_POST);die();
        $user = $this->user->find($id);
        // debug($id);
        if(empty($user)){
            redirect404();
        }
        try {
            $data = $_POST + $_FILES;
            // debug($data);
            // validate
            $validator = new Validator;

            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name' => 'required|max:50',
                    'email' => [
                        'required',
                        'email',
                        function ($value) use($id){
                            $flag = (new User)->checkExistsEmailForUpdate($id, $value);
                            if($flag){
                                return ":attribute has existed";
                            }
                        }
                    ],
                    'avatar' => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'type' => [$validator('in',['admin','client'])],
                ]
                );

                if(!empty($errors)){
                    $_SESSION['status'] = false;
                    $_SESSION['msg'] = 'Thao tác không thành công';
                    $_SESSION['errors'] = $errors;

                    redirect('/admin/users/edit/' .$id);
                }

                // upload file'

                if(is_upload('avatar')){
                    $data['avatar'] = $this->uploadFile($data['avatar'],'users');
                }else{
                    $data['avatar'] = $user['avatar'];
                }

                // điều chỉnh dl
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $data['updated_at'] = date('Y-m-d H:i:s');

                // update
                $this->user->update($id, $data);

                // Xóa ảnh cũ
                if($data['avatar'] != $user['avatar'] && $user['avatar'] && file_exists($user['avatar'])){
                    unlink($user['avatar']);
                }
                $_SESSION['status'] = true;
                $_SESSION['msg'] = 'Thao tác thành công';

                redirect('/admin/users');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());
            
            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            redirect('/admin/users/edit/'.$id);
        }
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