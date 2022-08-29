<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @if(\Illuminate\Support\Facades\Auth::check())
                    @php
                        $user = \Illuminate\Support\Facades\Auth::user();
                    @endphp
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">{{ $user->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="height: auto">

                            @if($user->avatar && file_exists(public_path($user->avatar)))
                                <img src="{{ asset($user->avatar) }}" class="img-circle" alt="">
                            @else
                                <img src="{{ asset('upload/user-404.png') }}" class="img-circle" alt="">
                            @endif
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('admin.user.edit',['user' => $user->id]) }}" class="btn btn-default btn-flat">Thiết lập</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Đăng xuất</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                @endif
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
