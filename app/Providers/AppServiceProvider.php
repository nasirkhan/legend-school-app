<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Native\Mobile\Edge\Components\Navigation\BottomNav;
use Native\Mobile\Edge\Components\Navigation\BottomNavItem;
use Native\Mobile\Edge\Components\Navigation\Fab;
use Native\Mobile\Edge\Components\Navigation\HorizontalDivider;
use Native\Mobile\Edge\Components\Navigation\SideNav;
use Native\Mobile\Edge\Components\Navigation\SideNavGroup;
use Native\Mobile\Edge\Components\Navigation\SideNavHeader;
use Native\Mobile\Edge\Components\Navigation\SideNavItem;
use Native\Mobile\Edge\Components\Navigation\TopBar;
use Native\Mobile\Edge\Components\Navigation\TopBarAction;
use Native\Mobile\Edge\NativeTagPrecompiler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // URL::forceHttps();

        // Manually register NativePHP Edge components to fix Windows path-separator
        // bug in NativeServiceProvider::registerNativeComponents().
        Blade::component('native-bottom-nav', BottomNav::class);
        Blade::component('native-bottom-nav-item', BottomNavItem::class);
        Blade::component('native-fab', Fab::class);
        Blade::component('native-horizontal-divider', HorizontalDivider::class);
        Blade::component('native-side-nav', SideNav::class);
        Blade::component('native-side-nav-group', SideNavGroup::class);
        Blade::component('native-side-nav-header', SideNavHeader::class);
        Blade::component('native-side-nav-item', SideNavItem::class);
        Blade::component('native-top-bar', TopBar::class);
        Blade::component('native-top-bar-action', TopBarAction::class);

        // The NativeTagPrecompiler captures a snapshot of Blade aliases at construction
        // time. On Windows, NativeServiceProvider (auto-discovered package) boots before
        // AppServiceProvider, so the precompiler is built before our aliases above are
        // registered. Replace it with a fresh instance so it picks up the current aliases.
        $blade = app(BladeCompiler::class);
        $ref = new \ReflectionProperty($blade, 'precompilers');
        $ref->setAccessible(true);
        $precompilers = $ref->getValue($blade);

        $precompilers = array_map(function ($precompiler) use ($blade) {
            if ($precompiler instanceof NativeTagPrecompiler) {
                return new NativeTagPrecompiler($blade);
            }

            return $precompiler;
        }, $precompilers);

        $ref->setValue($blade, $precompilers);
    }
}
