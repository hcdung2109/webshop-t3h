<div class="hero__categories">
    <div class="hero__categories__all">
        <i class="fa fa-bars"></i>
        <span>Danh mục</span>
    </div>
    <ul>
        @foreach($categories as $category)
            @if($category->parent_id == 0)
            <li><a href="{{ route('category', ['category' => $category->slug ]) }}">{{ $category->name }}</a></li>
            @endif
        @endforeach
    </ul>
</div>
