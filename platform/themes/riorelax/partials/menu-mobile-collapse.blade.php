<nav class="navbar navbar-expand-lg bg-body-tertiary menu-mobile d-lg-none">
    <div class="collapse navbar-collapse" id="menu-mobile-nav" >
        <div class="menu">
            <div class="menu-title">
                <span>{{ __('Menu') }}</span>
            </div>
            {!! Menu::renderMenuLocation('main-menu', [
                'view' => 'menu-mobile',
                'options' => ['class' => 'navbar-nav mb-2 mb-lg-0 me-3 ms-3'],
            ]) !!}
            @if (is_plugin_active('language') && ($supportedLocales = Language::getSupportedLocales()) && count($supportedLocales) > 1)
                <div class="menu-title mt-20">
                    <span>{{ __('Languages') }}</span>
                </div>
                <ul class="navbar-nav mb-2 mb-lg-0 me-3 ms-3">
                    {!! Theme::partial('language-switcher-mobile') !!}
                </ul>
            @endif

        </div>
    </div>
</nav>
