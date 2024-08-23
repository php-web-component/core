<?php

use PhpWebComponent\Component;
use PhpWebComponent\Component\Text;
use PhpWebComponent\Component\Text\Separator;

use function PhpWebComponent\{component, text};

$text = new Text();

test('Text Is Component', function () use ($text) {
    expect($text)->toBeInstanceOf(Component::class);
});

test('Text Is Text', function () use ($text) {
    expect($text)->toBeInstanceOf(Text::class);
});

test('Text Is String "Hello World!"', function () use ($text) {
    $text->set(
        'Hello',
        'World!',
    );

    expect(strval($text))->toBeString()->toBe('Hello World!');
});

test('Text Separator Is "+"', function () use ($text) {
    $text->set(
        (new Separator())->set('+'),
    );

    expect(strval($text))->toBeString()->toBe('Hello+World!');
});

test('Create Text with function', function () {
    $hello = component(Text::class)->set('Hello');

    expect($hello)->toBeInstanceOf(Component::class)->toBeInstanceOf(Text::class);

    $world = text('World');

    expect($world)->toBeInstanceOf(Component::class)->toBeInstanceOf(Text::class);

    expect(strval($hello).' '.strval($world))->toBeString()->toBe('Hello World');
});
