@extends('client.layouts.main')
@section('content')
    <!-- Header-->
    @include('client.layouts.partials.header')
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ file_url($product['p_img_thumbnail']) }}" alt="">
                </div>
                <div class="col-md-6">
                    <h1>{{ $product['p_name'] }}</h1>
                    <h6 class="text-secondary">{{ $product['c_name'] }}</h6>
                    <p class="mb-3">Mô tả: {{ $product['p_overview'] }}</p>
                    @if (isset($product['p_price_sale']) && $product['p_is_sale'] == 1)
                        <p>Giá:  <span class="mb-3 text-muted text-decoration-line-through">{{ $product['p_price'] }} VND</span> 
                        <span class="text-danger">{{ $product['p_price_sale'] }} VND</span></p>
                    @else
                       <p>Giá: <span class="mb-3">{{ $product['p_price'] }} VND</span></p>
                    @endif
                    @if ($product['p_is_active'] == 0)
                        <p>Trạng thái: <span class="badge bg-danger">Không hoạt động</span></p>
                    @else
                        <p>Trạng thái: <span class="badge bg-info">Hoạt động</span></p> 
                    @endif
                    <p> </p>
                    <br>
                    <button class="btn btn-primary mt-5">Thêm vào giỏ hàng</button>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col">
                    <h2>Mô tả chi tiết</h2>
                    <p>{!! $product['p_content'] !!}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
