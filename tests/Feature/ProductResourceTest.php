<?php

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

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

it('shows the create product button on the product list page', function () {
    $this->actingAs(User::factory()->create())
        ->get('/admin/products')
        ->assertOk()
        ->assertSee('/admin/products/create');
});

it('shows row edit and delete actions on the product table', function () {
    Product::query()->create([
        'code' => 'P-1002',
        'name' => 'Mouse',
        'price' => 150000,
        'stock' => 8,
        'is_active' => true,
    ]);

    $this->actingAs(User::factory()->create())
        ->get('/admin/products')
        ->assertOk()
        ->assertSee('Edit')
        ->assertSee('Delete');
});

it('filters out-of-stock products when the stock ternary filter is enabled', function () {
    $outOfStock = Product::query()->create([
        'code' => 'P-2001',
        'name' => 'Out of stock item',
        'price' => 100000,
        'stock' => 0,
        'is_active' => true,
    ]);

    $inStock = Product::query()->create([
        'code' => 'P-2002',
        'name' => 'In stock item',
        'price' => 200000,
        'stock' => 10,
        'is_active' => true,
    ]);

    $query = Livewire::actingAs(User::factory()->create())
        ->test(ListProducts::class)
        ->instance()
        ->getTable()
        ->getFilter('stock')
        ->apply(Product::query(), ['value' => true]);

    expect($query->pluck('name')->all())
        ->toContain($outOfStock->name)
        ->not->toContain($inStock->name);
});
