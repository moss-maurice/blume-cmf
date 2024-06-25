Api plugins test page

@php
    // Получение всех плагинов
    dump(blume()->plugins()->allPlugins()->toArray());

    // Получение всех установленных плагинов
    dump(blume()->plugins()->installedPlugins()->toArray());

    // Получение всех не установленных плагинов
    dump(blume()->plugins()->notInstalledPlugins()->toArray());

    // Проверка плагина foo на установку в системе
    dump(blume()->plugins()->isInstalledPlugin('foo'));

    // Установка плагина foo
    dump(blume()->plugins()->installPlugin('foo'));

    // Деинсталляция плагина foo
    dump(blume()->plugins()->uninstallPlugin('foo'));

    // Получение списка активированных плагинов
    dump(blume()->plugins()->activedPlugins()->toArray());

    // Получение списка не активированных плагинов
    dump(blume()->plugins()->notActivedPlugins()->toArray());

    // Проверка плагина foo на активацию
    dump(blume()->plugins()->isActivatedPlugin('foo'));

    // Активация плагина foo
    dump(blume()->plugins()->activatePlugin('foo'));

    // Деактивация плагина foo
    dump(blume()->plugins()->deactivatePlugin('foo'));
@endphp
