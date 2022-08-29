@extends('frontend.sub-layouts.main')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Tìm kiếm : {{ $keyword }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="product spad">
        <div class="container">
            <div class="row">
                <h2>Có {{ $totalResult }} sản phẩm với từ khóa: {{ $keyword }}</h2>
                <div class="col-lg-12 col-md-12">
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span>16</span> Products found</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg"
                                         data-setbg="
                                            @if($product->image && file_exists(public_path($product->image)))
                                             {{ asset($product->image) }}
                                            @else
                                                 {{ asset('upload/404.png') }}
                                            @endif
                                             ">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="{{ route('product', ['product' => $product->slug]) }}">{{ $product->name }}</a></h6>
                                        <h5 style="color: #9c3328">{{ number_format($product->sale,0,",",".") }} đ</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="product__pagination">

                    </div>

                    {!! $products->appends(['kwd' => $keyword])->links('vendor.pagination.custom') !!}
                </div>
            </div>
        </div>
    </section>

@endsection
