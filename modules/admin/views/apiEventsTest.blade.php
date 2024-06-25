Api events test page

@php
    use Blume\Events\ExampleEvent;
    use Plugins\Bar\Listeners\SomeEventListener;

    // Все зарегистрированные события
    dump(blume()->events()->allEvents()->toArray());

    // Проверка на регистрацию метода onTest
    dump(blume()->events()->isRegisteredEvent('onTest'));

    // Регистрация класса ExampleEvent в качесиве хэндлера события onTest
    dump(blume()->events()->registerEvent('onTest', ExampleEvent::class));

    // Проверка на регистрацию метода onTest
    dump(blume()->events()->isRegisteredEvent('onTest'));

    // Отмена регистрации метода onTest
    dump(blume()->events()->unregisterEvent('onTest'));

    // Проверка на регистрацию метода onTest
    dump(blume()->events()->isRegisteredEvent('onTest'));

    // Регистрация класса ExampleEvent в качесиве хэндлера события onTest
    dump(blume()->events()->registerEvent('onTest', ExampleEvent::class));

    // Получение списка зарегистрированных слушателей для события onTest
    dump(blume()->events()->listeners('onTest')->toArray());

    // Проверка класса слушателя SomeEventListener на регистрацию к событию onTest
    dump(blume()->events()->isRegisteredListener('onTest', SomeEventListener::class));

    // Регистрация класса SomeEventListener в качестве слушателя события onTest
    dump(blume()->events()->registerListener('onTest', SomeEventListener::class));

    // Проверка класса слушателя SomeEventListener на регистрацию к событию onTest
    dump(blume()->events()->isRegisteredListener('onTest', SomeEventListener::class));

    // Отмена регистрации класса SomeEventListener в качестве слушателя события onTest
    dump(blume()->events()->unregisterListener('onTest', SomeEventListener::class));

    // Проверка класса слушателя SomeEventListener на регистрацию к событию onTest
    dump(blume()->events()->isRegisteredListener('onTest', SomeEventListener::class));

    // Отмена регистрации класса SomeEventListener в качестве слушателя события onTest
    dump(blume()->events()->registerListener('onTest', SomeEventListener::class));

    // Вызов события onTest (запускает выполнение всех слушателей)
    dump(blume()->events()->callEvent('onTest'));

    // Получение списка зарегистрированных слушателей для события onTest
    dump(blume()->events()->listeners('onTest')->toArray());

    // Отмена регистрации всех слушателей события onTest
    dump(blume()->events()->unregisterAllListener('onTest'));

    // Получение списка зарегистрированных слушателей для события onTest
    dump(blume()->events()->listeners('onTest')->toArray());
@endphp
