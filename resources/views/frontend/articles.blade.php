@extends('frontend.sub-layouts.main')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Tin tức</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        @foreach($articles as $article)
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    @if($article->image && file_exists(public_path($article->image)))
                                        <img src="{{ asset($article->image) }}" alt="">
                                    @else
                                        <img src="{{ asset('upload/404.png') }}"  alt="">
                                    @endif
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i> {{ date('d/m/Y', strtotime($article->updated_at)) }}</li>
                                    </ul>
                                    <h5><a href="{{ route('detail-article', ['slug' => $article->slug]) }}">{{ $article->title }}</a></h5>
                                    <p>{!! $article->summary !!}</p>
                                    <a href="{{ route('detail-article', ['slug' => $article->slug]) }}" class="blog__btn">Chi tiết <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="col-lg-12">
                            <div class="product__pagination blog__pagination">
                                {{ $articles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
