Api modules test page

@php
    // Получение списка всех зарегистрированных модулей
    dump(blume()->modules()->allModules()->toArray());
@endphp
