<!-- resources/views/layouts/partial/navigation.blade.php -->
<nva class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a href="{{route('home')}}" class="navbar-brand">
                <img src="/images/laravel_logo.png" alt="logo" style="display: block; height: 1.2rem;" />
            </a>
        </div>

        <div class="collapse navbar-collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav navbar-right">
                @if(!auth()->check())
                <li>
                    <a href="{{ route('login') }}"><i class="fa fa-sign-in icon"></i> Login</a>
                </li>
                <li>
                    <a href="{{ route('register') }}"><i class="fa fa-certificate icon"></i> Sign up</a>
                </li>
                else
                <li>
                    <a href="{-- route(document.show) --}"><i class="fa"></i> Document Viewer</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-weixin icon"></i> Forum</a></li>
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-user icon"></i>  <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();"><i class="fa fa-sign-out icon"></i>Logout</a>

                            <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nva>