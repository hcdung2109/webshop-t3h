<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="header__logo">
                <a href="/"><img src="{{ asset($setting->image) }}" alt=""></a>
            </div>
        </div>
        <div class="col-lg-6">
            <nav class="header__menu">
                <ul>
                    <li class="active"><a href="/">Trang chủ</a></li>
                    <li><a href="{{ route('introduce') }}">Giới thiệu</a></li>
                    <li><a href="{{ route('articles') }}">Tin tức</a></li>
                    <li><a href="{{ route('contact') }}#form">Liên Hệ</a></li>
                </ul>
            </nav>
        </div>
        <div class="col-lg-3">
            <div class="header__cart">
                <ul>
                    <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                    <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                </ul>
                <div class="header__cart__price">item: <span>$150.00</span></div>
            </div>
        </div>
    </div>
    <div class="humberger__open">
        <i class="fa fa-bars"></i>
    </div>
</div>
