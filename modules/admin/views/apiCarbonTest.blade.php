Api carbon test page

@php
    // Пример взаимодействия с Carbon
    dump(blume()->carbon()::now()->format('Y-m-d H:i:s'));

    // Прочие методы тут: https://carbon.nesbot.com/docs/
@endphp
