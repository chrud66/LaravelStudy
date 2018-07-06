<!-- resources/views/layouts/partial/footer.blade.php -->
<footer class="footer d-flex p-4 mt-5 border-top text-muted">
        <div class="container">
        <ul class="list-inline pull-right locale">
            <li class="list-inline-item">{!! icon('locale') !!}</li>
            @foreach (['ko' => '한국어', 'en' => 'English'] as $locale => $language)
            <li class="list-inline-item pl-2 pr-2 {{ ($locale == $currentLocale) ? 'bg-primary' : '' }}">
                <a href="{{ route('locale', ['locale' => $locale, 'return' => urlencode($currentUrl)]) }}" {!! ($locale == $currentLocale) ? 'class="text-white"' : '' !!}>
                    {{ $language }}
                </a>
            </li>
            @endforeach
        </ul>

        <div>
            &copy; {{ date('Y') }} &nbsp; <a href="https://github.com/chrud66/laravel" target="_blank">Github Laravel Study</a>
        </div>
    </div>
</footer>