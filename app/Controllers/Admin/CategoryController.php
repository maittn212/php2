<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\Category;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class CategoryController extends Controller
{
    private Category $category;
    public function __construct()
    {
        $this->category = new Category();
    }
    public function index()
    {
        $title = 'Danh sách danh mục';
        $data = $this->category->findAll();
        return view('admin.categories.index', compact('title', 'data'));
    }
    public function create()
    {
        $title = 'Thêm mới danh mục';
        return view('admin.categories.create');
    }

    public function store()
    {
        try {
            $data = $_POST + $_FILES;
            // debug($data);
            $validator = new Validator();

            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name'          => [
                        'required',
                        'max:50',
                        function ($value) {
                            $flag = (new Category)->checkExistNameForCreate($value);
                            if ($flag) {
                                return ':attribute has existed';
                            }
                        }
                    ],
                    'img'              => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'        => [$validator('in', [0, 1])]
                ]
            );
            if (!empty($errors)) {
                $_SESSION['status'] = false;
                $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
                $_SESSION['data'] = $_POST;
                $_SESSION['errors'] = $errors;

                redirect('/admin/categories/create');
            } else {
                $_SESSION['data'] = null;
            }

            // upload file
            if (is_upload('img')) {
                $data['img'] = $this->uploadFile($data['img'], 'categories');
            } else {
                $data['img'] = null;
            }

            // Điều chỉnh dữ liệu
            $data['is_active'] = $data['is_active'] ?? 0;

            // insert
            $this->category->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công';

            redirect('/admin/categories');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['data'] = $_POST;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';

            redirect('/admin/categories/create');
        }
    }

    public function show($id)
    {
        $title = 'Chi tiết danh mục';
        $category = $this->category->find($id);
        if (empty($category)) {
            redirect404();
        }
        return view('admin.categories.show', compact('title', 'category'));
    }

    public function edit($id){
        $title = 'Cập nhật danh mục';
        $category = $this->category->find($id);
        // debug($category);
        if (empty($category)) {
            redirect404();
        }
        return view('admin.categories.edit',compact('title', 'category'));

    }
    public function update($id)
    {
        $category = $this->category->find($id);
        if (empty($category)) {
            redirect404();
        }
        try {
            $data = $_POST + $_FILES;
            $validator = new Validator;

            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name'      =>  [
                        'required',
                        'max:50',
                        function ($value) use ($id) {
                            $flag = (new Category)->checkExistNameForUpdate($id, $value);

                            if ($flag) {
                                return ":attribute has existed";
                            }
                        }
                    ],
                    'img'          => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'    => [$validator('in', [0, 1])]
                ]
            );
            if (!empty($errors)) {
                $_SESSION['status'] = false;
                $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
                $_SESSION['errors'] = $errors;

                redirect('/admin/categories/edit/' . $id);
            }

            // upload file
            if (is_upload('img')) {
                $data['img'] = $this->uploadFile($data['img'], 'categories');
            } else {
                $data['img'] = $category['img'];
            }
            // Điều chỉnh dữ liệu
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $data['is_active'] = $data['is_active'] ?? 0;
            $data['updated_at'] = date('Y-m-d H:i:s');

            // update
            $this->category->update($id, $data);

            if($data['img'] != $category['img'] && $category['img'] && file_exists($category['img'])){
                unlink($category['img']);
            }

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công';

            redirect('/admin/categories');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['data'] = $_POST;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';

            redirect('/admin/categories/edit/'.$id);
        }
    }

    public function delete($id)
    {
        $category = $this->category->find($id);
        if (empty($category)) {
            redirect404();
        }
        $this->category->delete($id);
        if ($category['img'] && file_exists($category['img'])) {
            unlink($category['img']);
        }
        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Thao tác thành công';

        redirect('/admin/categories');
    }
}
