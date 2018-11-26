<aside class="transition admin-menubar">
    <div class="logo-area transition">
        <h1 class="logo">
            <a href="{{ route('admin.') }}">
                <img src="/images/logo-laravel-3.png" style="display: inline-block; height: 2rem;">
                Admin
            </a>
        </h1>
    </div>
    <p class="list-title">MAIN MENU</p>
    <ul class="snb-list">
        <li class="on">
            <a href="{{ route('admin.dashboard') }}">
                {!! icon('menubar', 'admin-icon') !!}
                대시보드
            </a>
        </li>
        <li class="config-boards">
            <a href="#">
                {!! icon('menubar', 'admin-icon') !!}
                게시판 설정 관리
            </a>
        </li>
        <li class="boads-manages sub-depth">
            <a href="javascript:;">
                {!! icon('menubar', 'admin-icon') !!}
                게시판 관리
            </a>
            <button type="button" class="btn-link toggle collapseMenu">
                {!! icon('arrow-right', 'admin-icon') !!}
            </button>
            <ul class="sub-depth-list">
                <li>
                    <a href="#">전체 게시판 목록</a>
                </li>
                <li>
                    <a href="#">자유게시판</a>
                </li>
                <li class="sub-depth">
                    <a href="#">회원게시판</a>
                    <button type="button" class="btn-link toggle">
                        {!! icon('arrow-right', 'admin-icon') !!}
                    </button>
                    <ul class="sub-depth-list">
                        <li>
                            <a href="#">테스트 1</a>
                        </li>
                        <li>
                            <a href="#">테스트 2</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</aside>