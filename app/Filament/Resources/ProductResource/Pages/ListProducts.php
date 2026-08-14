<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductResource\Widgets\ProductStatsOverview;
use Filament\Actions\CreateAction;
use Filament\Actions\Action as ActionsAction;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ActionsAction::make('Refresh')
                ->action(fn() => $this->dispatch('refreshStatsOverviewWidget'))
                ->icon('heroicon-o-arrow-path')
                ->color('primary'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProductStatsOverview::class,
        ];
    }
}
