<?php

use PhpWebComponent\Component;

test('Create Component', function () {
    $component = new class () extends Component {};

    expect($component)->toBeInstanceOf(Component::class);
});
