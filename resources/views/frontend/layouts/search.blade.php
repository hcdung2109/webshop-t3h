<div class="hero__search">
    <div class="hero__search__form">
        <form action="{{ route('search') }}" method="get">
            <div class="hero__search__categories">
                All Categories
                <span class="arrow_carrot-down"></span>
            </div>
            <input name="kwd" type="text" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit" class="site-btn">Tìm kiếm</button>
        </form>
    </div>
    <div class="hero__search__phone">
        <div class="hero__search__phone__icon">
            <i class="fa fa-phone"></i>
        </div>
        <div class="hero__search__phone__text">
            <h5>+65 11.188.888</h5>
            <span>support 24/7 time</span>
        </div>
    </div>
</div>
