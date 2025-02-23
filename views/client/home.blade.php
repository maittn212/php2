@extends('client.layouts.main')
<style>
    .carousel-item img {
        height: 550px;
        object-fit: cover;
    }
</style>
@section('content')
    <!-- Header-->
    @include('client.layouts.partials.header')
    <!-- Slideshow -->
    <div id="carouselExampleIndicators" class="carousel slide mt-3" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach ($visibleBanner as $index => $banner)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}"
                    class="{{ $index == 0 ? 'active' : '' }}"></li>
            @endforeach

        </ol>

        <div class="carousel-inner">
            @foreach ($visibleBanner as $index => $banner)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img class="d-block w-100" src="{{ file_url($banner['img']) }}" alt="{{ $banner['name'] }}">
                    {{-- <p>{{file_url($banner['img'])}}</p> --}}
                </div>
            @endforeach
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($visivleProducts as $product)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="{{ file_url($product['img_thumbnail']) }}" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $product['name'] }}</h5>
                                    <!-- Product price-->
                                    @if (isset($product['price_sale']) && $product['is_sale'] == 1)
                                        <span class="text-muted text-decoration-line-through">{{ $product['price'] }}
                                            VND</span>
                                        <span class="text-danger">{{ $product['price_sale'] }} VND</span>
                                    @else
                                        <p class="">{{ $product['price'] }} VND</p>
                                    @endif
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto"
                                        href="/product/{{ $product['id'] }}">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
