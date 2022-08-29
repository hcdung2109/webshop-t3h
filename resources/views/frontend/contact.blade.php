@extends('frontend.layouts.main')

@section('content')
    <section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_phone"></span>
                    <h4>Phone</h4>
                    <p>+01-3-8888-6868</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_pin_alt"></span>
                    <h4>Address</h4>
                    <p>60-49 Road 11378 New York</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_clock_alt"></span>
                    <h4>Open time</h4>
                    <p>10:00 am to 23:00 pm</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <div class="contact__widget">
                    <span class="icon_mail_alt"></span>
                    <h4>Email</h4>
                    <p>hello@colorlib.com</p>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- Contact Section End -->

    <!-- Map Begin -->
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d49116.39176087041!2d-86.41867791216099!3d39.69977417971648!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x886ca48c841038a1%3A0x70cfba96bf847f0!2sPlainfield%2C%20IN%2C%20USA!5e0!3m2!1sen!2sbd!4v1586106673811!5m2!1sen!2sbd"
            height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        <div class="map-inside">
            <i class="icon_pin"></i>
            <div class="inside-widget">
                <h4>New York</h4>
                <ul>
                    <li>Phone: +12-345-6789</li>
                    <li>Add: 16 Creek Ave. Farmingdale, NY</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Map End -->

    <!-- Contact Form Begin -->
    <div class="contact-form spad">
        <div class="container">

            @if (session('msgContact'))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="contact__form__title">
                            <h3 style="color: green">{{ session('msgContact') }}</h3>
                        </div>
                        <a href="/"><i class="fa fa-backward" aria-hidden="true"></i> Quay về trang chủ</a>
                    </div>
                </div>
            @else
                <div class="row" id="form">
                    <div class="col-lg-12">
                        <div class="contact__form__title">
                            <h2>Gửi thông tin liên hệ</h2>
                        </div>
                    </div>
                </div>

                <form action="{{ route('contactPost') }}" method="POST" id="contact">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <input value="{{ old('name') }}" class="" name="name" id="name" type="text" placeholder="Tên">
                            @error('name')
                            <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <input value="{{ old('email') }}" name="email" id="email" type="email" placeholder="Email">
                            @error('email')
                            <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <input value="{{ old('phone') }}" name="phone" id="phone" type="text" placeholder="SĐT">
                            @error('phone')
                            <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-lg-12 text-center">
                            <textarea name="content" id="content" placeholder="Tin nhắn">{{ old('content') }}</textarea>
                            @error('content')
                            <p style="color: red;">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="site-btn btnSend">GỬi</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.btnSend').click(function () {
                if ($('#name').val() === '') {
                    $('#name').notify('Bạn  chưa nhập tên','error');
                    document.getElementById('name').scrollIntoView();
                    return false;
                }

                if ($('#email').val() === '') {
                    $('#email').notify('Bạn chưa nhập email','error');
                    document.getElementById('email').scrollIntoView();
                    return false;
                }

                if ($('#phone').val() === '') {
                    $('#phone').notify('Bạn  chưa nhập phone','error');
                    document.getElementById('email').scrollIntoView();
                    return false;
                }

                if ($('#content').val() === '') {
                    $('#content').notify('Bạn chưa nhập tin nhắn','error');
                    document.getElementById('email').scrollIntoView();
                    return false;
                }
            });
        });
    </script>
@endsection
