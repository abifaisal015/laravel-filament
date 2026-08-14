<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductStatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = null;

    protected $listeners = [
        'refreshStatsOverviewWidget' => '$refresh',
    ];

    protected function getStats(): array
    {
        return [
            Stat::make('Total Product', Product::count())
                ->description('Total semua produk di database')
                ->color('success'),

            Stat::make('Total Stock', Product::sum('stock'))
                ->description('Total stok dari semua produk')
                ->color('warning'),

            Stat::make('Stock Habis', Product::where('stock', 0)->count())
                ->description('Jumlah produk dengan stok 0')
                ->color('danger'),
        ];
    }
}
