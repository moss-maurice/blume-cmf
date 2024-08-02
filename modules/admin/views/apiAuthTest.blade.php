Api auth test page

@php
    // Проверка почны на наличие регистрации
    dump(blume()->auth()->isRegistered('kreexus@gmail.com'));

    // Регистрация нового аккаунта
    dump(blume()->auth()->register('Admin', 'kreexus@gmail.com', 'qwerty123', 'admin'));

    // Получение статуса авторизации текущего пользователя
    dump(blume()->auth()->isLogged());

    // Выход из текущего аккаунта
    dump(blume()->auth()->logout());

    // Получение статуса авторизации текущего пользователя
    dump(blume()->auth()->isLogged());

    // Сброс пароля
    //dump(blume()->auth()->resetPassword('kreexus@gmail.com', '123qwerty', '2fcad4ea76ae2bce9574f02885fd36e07c523264fba2199ecdb639665463a8b4'));

    // Авторизация аккаунта
    dump(blume()->auth()->login('kreexus@gmail.com', '123qwerty'));

    // Отправка ссылки на сброс пароля
    //dump(blume()->auth()->sendResetPasswordLink('kreexus@gmail.com'));

    // Получение статуса авторизации текущего пользователя
    dump(blume()->auth()->isLogged());

    // Выход из текущего аккаунта
    dump(blume()->auth()->logout());
@endphp
