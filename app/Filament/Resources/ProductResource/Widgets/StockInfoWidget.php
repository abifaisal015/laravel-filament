<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Actions\Action;

class StockInfoWidget extends BaseWidget
{
    protected ?string $pollingInterval = null;
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh')
                ->color('secondary')
                ->icon('heroicon-o-arrow-path')
                ->action('refreshData'),
        ];
    }
    
    public function refreshData(): void
    {
        $this->dispatch('$refresh');
    }
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Product', Product::count())
                ->description('Jumlah total produk')
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