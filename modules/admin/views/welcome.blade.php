Welcome to blume admin module

@php
    // Получение наименование проекта
    dump(blume()->name());

    // Получение версии проекта
    dump(blume()->version());

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
@endphp
