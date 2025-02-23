@extends('admin.layouts.main');
@section('title')
    {{ $title }}
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>
    <h1 class="h2">{{ $title }}</h1>

    @include('admin.components.display-msg-fail')
    @include('admin.components.display-msg-success')
    @include('admin.components.display-errors')

    <div class="row">
        <div class="col-12 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <form action="/admin/banners/update/{{$banner['id']}}" method="POST" enctype="multipart/form-data">
                            <div class="mb-3 row">
                                <label for="inputName" class="col-4 col-form-label">Name</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{$banner['name']}}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputName" class="col-4 col-form-label">Img</label>
                                <div class="col-8">
                                    <input type="file" class="form-control" name="img" id="img" />
                                  @if ($banner['img']!== null)
                                    <img src="{{file_url($banner['img'])}}" width="100px">    
                                  @else
                                      <span class="badge bg-secondary">Không có ảnh</span>
                                  @endif
                                </div>
                            </div>
                            <div class="mb-3 row align-items-center">
                                <label for="is_active" class="col-4 col-form-label">Is Active?</label>
                                <div class="col-8">
                                    <input type="checkbox" class="form-check-input" @checked($banner['is_active']) value="1" name="is_active" id="is_active" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="offset-sm-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                    <a href="/admin/banners" class="btn btn-warning">Back to list</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
