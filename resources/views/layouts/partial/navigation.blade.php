<!-- resources/views/layouts/partial/navigation.blade.php -->
<header>
    <nav class="navbar navbar-expand-md navbar-light box-shadow d-flex p-3 px-md-4 mb-3 bg-white border-bottom fixed-top"> <!--fixed-top-->
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="/images/logo-laravel-3.png" style="display: inline-block; height: 2rem;"/>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="sr-only">Toggle Navigation</span>
        </button>

        <div class="navbar-collapse collapse" id="navbarCollapse" style="">
            <ul class="navbar-nav mr-auto justify-content-end">
                @if(!Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in icon"></i> Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}"><i class="fa fa-certificate icon"></i> Sign up</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{-- route(document.show) --}"><i class="fa"></i> Document Viewer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-weixin icon"></i> Forum</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user icon"></i> {{ Auth::user()->name }} <b class="caret"></b>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();"><i class="fa fa-sign-out icon"></i>Logout</a>

                        <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</header>