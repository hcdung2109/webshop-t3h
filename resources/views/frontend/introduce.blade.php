@extends('frontend.layouts.main')

@section('content')
    <section class="blog-details spad" style="padding: 0px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="blog__details__text">
                        <h3>Về chúng tôi</h3>
                        {!! $setting->content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $( document ).ready(function() {

        });
    </script>
@endsection
