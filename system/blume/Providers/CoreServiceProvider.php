<?php

namespace Blume\Providers;

use Blume\Foundation\Core\AuthResolver;
use Blume\Foundation\Core\EventsResolver;
use Blume\Foundation\Core\ModulesResolver;
use Blume\Foundation\Core\PluginsResolver;
use Blume\Foundation\Core\UsersResolver;
use Blume\Services\CoreService;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CoreService::class, function ($app) {
            return new CoreService;
        });

        // Пример регистрации класса ClassName в качестве узла nodeName API-слоя ядра
        // Вызываеися как blume()->{nodeName}()
        // Наследует все методы регистрируемого класса
        //blume()->registerNode('nodeName', ClassName::class);

        // Пример регистрации метода classMethodName класса ClassName в качестве метода methodName узла nodeName API-слоя ядра
        // Вызывается как blume()->{nodeName}()->{methodName}();
        //blume()->registerNodeMethod('nodeName', 'methodName', [ClassName::class, 'classMethodName']);

        // Пример регистрации анонимной функции в качестве метода methodName узла nodeName API-слоя ядра
        // Вызывается как blume()->{nodeName}()->{methodName}();
        //blume()->registerNodeMethod('nodeName', 'methodName', function () {
        //    return 'foo bar';
        //});

        blume()->registerNode('auth', AuthResolver::class);
        blume()->registerNode('users', UsersResolver::class);
        blume()->registerNode('modules', ModulesResolver::class);
        blume()->registerNode('events', EventsResolver::class);
        blume()->registerNode('plugins', PluginsResolver::class);
        blume()->registerNode('carbon', Carbon::class);
    }
}
