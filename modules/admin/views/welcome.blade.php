Welcome to blume module

@php
    use Blume\Events\ExampleEvent;

    event(new ExampleEvent);

    dump(blume()->name());

    dump(blume()->version());
@endphp
