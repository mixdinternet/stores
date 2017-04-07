<?php

namespace Mixdinternet\Stores\Providers;

use Illuminate\Support\ServiceProvider;
use Pingpong\Menus\MenuFacade as Menu;

class StoresServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->setMenu();
        $this->setRoutes();
        $this->loadViews();
        $this->loadMigrations();
        $this->publish();
    }

    public function register()
    {
        $this->loadConfigs();
    }

    protected function setMenu()
    {
        Menu::modify('adminlte-sidebar', function ($menu) {
            $menu->route('admin.stores.index', config('mstores.name', 'Lojas'), [], config('mstores.order', 30)
                , ['icon' => config('mstores.icon', 'fa fa-industry'), 'active' => function () {
                    return checkActive(route('admin.stores.index'));
                }])->hideWhen(function () {
                return checkRule('admin.stores.index');
            });
        });

        Menu::modify('adminlte-permissions', function ($menu) {
            $menu->url('admin.stores', config('mstores.name', 'Lojas'), config('mstores.order', 30));
        });
    }

    protected function setRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $this->app->router->group(['namespace' => 'Mixdinternet\Stores\Http\Controllers'],
                function () {
                    require __DIR__ . '/../routes/web.php';
                    require __DIR__ . '/../routes/api.php';
                });
        }
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mixdinternet/stores');
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/maudit.php', 'maudit.alias');
        $this->mergeConfigFrom(__DIR__ . '/../config/mstores.php', 'mstores');
        $this->mergeConfigFrom(__DIR__ . '/../config/maps.php', 'maps');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/mixdinternet/stores'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../config' => base_path('config'),
        ], 'config');
    }
}