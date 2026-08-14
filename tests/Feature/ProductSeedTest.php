<?php

use App\Models\Product;
use App\Models\User;

it('can seed product data repeatedly without duplicating the default user', function () {
    $this->seed();
    $this->seed();

    expect(Product::count())->toBeGreaterThan(0)
        ->and(User::where('email', 'test@example.com')->count())->toBe(1);
});
