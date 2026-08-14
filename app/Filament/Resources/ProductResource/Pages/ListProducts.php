<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\Url;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    #[Url]
    public bool $showStockInfo = false;

    public function toggleStockInfo(): void
    {
        $this->showStockInfo = !$this->showStockInfo;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggleStock')
                ->label(fn () => $this->showStockInfo ? 'Hide Stock Information' : 'Show Stock Information')
                ->color('primary')
                ->action('toggleStockInfo')
                ->extraAttributes([
                    'x-data' => "{ processing: false }",
                    '@click' => 'processing = true; $wire.toggleStockInfo().then(() => processing = false);',
                    'x-bind:disabled' => 'processing',
                ]),
            Action::make('refresh')
                ->label('Refresh')
                ->icon(Heroicon::OutlinedArrowPath)
                ->color('primary')
                ->action(function () {
                    $this->dispatch('refreshTable');
                    $this->dispatch('$refresh');
                }),
            CreateAction::make(),
        ];
    }

    public function getHeaderWidgets(): array
    {
        if (!$this->showStockInfo) {
            return [];
        }

        return [
            \App\Filament\Resources\ProductResource\Widgets\StockInfoWidget::class,
        ];
    }
}