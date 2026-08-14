<?php

use App\Models\Product;
use App\Models\User;

it('shows products on the admin product page', function () {
    $this->seed();

    $user = User::where('email', 'test@example.com')->firstOrFail();
    $productName = Product::query()->orderBy('name')->value('name');

    $response = $this->actingAs($user)->get('/admin/products');

    $response->assertOk()
        ->assertSee('Products')
        ->assertSee($productName);
});
