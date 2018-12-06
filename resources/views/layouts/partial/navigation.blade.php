<!-- resources/views/layouts/partial/navigation.blade.php -->
<header>
    <nav class="navbar navbar-expand-md navbar-light box-shadow d-flex p-3 px-md-4 mb-3 bg-white border-bottom fixed-top">
        <div class="container">
            <a href="{{ Auth::check() ? route('home') : route('root') }}" class="navbar-brand">
                <img src="/images/logo-laravel-3.png" style="display: inline-block; height: 2rem;"/>
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="sr-only">Toggle Navigation</span>
            </button>

            <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pdf-to-img.index') }}">{!! icon('change') !!} Pdf to image</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('images-to-pdf.index') }}" class="nav-link">
                            {!! icon('change') !!} Images to Pdf
                        </a>
                    </li>
                    @if(!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{!! icon('login') !!} {{ __('auth.title_login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{!! icon('certificate') !!} {{ __('auth.title_signup') }}</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('articles.index')}}">{!! icon('forum') !!} Forum</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            {!! icon('user') !!} {{ Auth::user()->name }} <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @hasanyrole('최고 관리자|관리자')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                               {!! icon('setting') !!} 관리자 페이지
                            </a>
                            @endhasanyrole

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();">{!! icon('logout') !!} {{ __('auth.title_logout') }}</a>

                            <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>