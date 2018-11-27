<header>
    <button type="button" class="btn-slide" title="메뉴 숨기기">
        {!! icon('outdent', 'admin-icon') !!}
        <span class="sr-only">메뉴 숨기기</span>
    </button>
    <a href="{{ url('/') }}" class="btn-site-home">
        {!! icon('home', 'admin-icon') !!}
        <span class="sr-only">홈으로 이동</span>
    </a>
    <div class="right-menu navbar-light box-shadow" id="navbarCollapse">
        <ul class="navbar-nav ml-auto justify-content-end">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle-split" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <div>
                        <span class="hidden-xs">{{ Auth::user()->name }}</span> {!! icon('down', 'admin-icon') !!}
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="dropdown-item" onclick="event.preventDefault(); $('#logout-form').submit();">
                                {!! icon('logout', 'admin-icon') !!}
                                로그아웃
                            </a>
                            @include('common.logout_form')
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</header>