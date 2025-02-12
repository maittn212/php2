{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{!! $title !!}</h1>
{{-- 
    <ul>
        @foreach ($data as $user )
            <li>{{ $user['id'] . ' - ' . $user['name']. ' - ' . $user['email'] }}</li>
        @endforeach
    </ul>

    @if (isset($_SESSION['msg']))
        <h2>{{$_SESSION['msg']}}</h2>
    @endif
    <form action="/admin/users/testUploadFile" method="POST" enctype="multipart/form-data">
        <label for="avatar">Choose avatar:</label>
        <input type="file" name="avatar" id="avatar" required>
        <br> <br>
        <button type="submit">Upload</button>
    </form> --}}
    

@extends('admin.layouts.main');
@section('title')
    {{$title}}
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
    </ol>
</nav>
<h1 class="h2">{{$title}}</h1>

@include('admin.components.display-msg-fail')
@include('admin.components.display-msg-success')


<div class="row">
    <div class="col-12 mb-4 mb-lg-0">
        <div class="card">
            <a href="/admin/users/create" class="btn btn-sm btn-success">Create</a>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Type</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($data as $user)
                                     <tr>
                                           <td scope="row">{{$user['id']}}</td>
                                        <td>{{$user['name']}}</td>
                                        <td>{{$user['email']}}</td>
                                        <td>
                                            <img src="{{file_url($user['avatar'])}}" width="100px">
                                        </td>
                                        <td>
                                            @if ($user['type'] == 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @else
                                                <span class="badge bg-info">Client</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/admin/users/show/{{$user['id']}}" class="btn btn-sm btn-info">Show</a>
                                            <a href="/admin/users/edit/{{$user['id']}}" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="/admin/users/delete/{{$user['id']}}" class="btn btn-sm btn-danger" onclick="return confirm('Có chắc chắn xóa không?')">Delete</a>
                                        </td>
                                     </tr>

                                @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <a href="#" class="btn btn-block btn-light">View all</a>
            </div>
        </div>
    </div>
</div>
@endsection