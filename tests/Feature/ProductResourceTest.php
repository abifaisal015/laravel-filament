<?php

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;

it('can access the product resource index in the admin panel', function () {
    Product::query()->create([
        'code' => 'P-1001',
        'name' => 'Keyboard',
        'price' => 250000,
        'stock' => 10,
        'is_active' => true,
    ]);

    $this->actingAs(User::factory()->create())
        ->get('/admin/products')
        ->assertOk();
});

it('has the expected product resource configuration', function () {
    expect(ProductResource::getModel())->toBe(Product::class);
    expect(ProductResource::getPages())->toHaveKeys(['index', 'create', 'edit']);
});
