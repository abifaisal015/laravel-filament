<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function canAccess(): bool
    {
        return true;
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit(Model $record): bool
    {
        return true;
    }

    public static function canDelete(Model $record): bool
    {
        return true;
    }

    public static function canDeleteAny(): bool
    {
        return true;
    }

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'products', column: 'code', ignoreRecord: true),

                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name', 'id'))
                    ->searchable(),

                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01),

                TextInput::make('stock')
                    ->label('Stock')
                    ->required()
                    ->integer()
                    ->minValue(0),

                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format((float) $state, 2, ',', '.'))
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Stock'),

                BadgeColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(fn(?bool $state): string => $state ? 'Active' : 'Inactive')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                EditAction::make(),
                \Filament\Actions\Action::make('deactivate')
                    ->label('Deactivate')
                    ->color('danger')
                    ->icon(Heroicon::OutlinedXMark)
                    ->requiresConfirmation()
                    ->modalHeading('Deactivate Product')
                    ->modalDescription('Are you sure you want to deactivate this product?')
                    ->modalSubmitActionLabel('Yes, deactivate it')
                    ->action(function (Product $record) {
                        if ($record->stock > 0) {
                            \Filament\Notifications\Notification::make()
                                ->danger()
                                ->title('Product cannot be deactivated')
                                ->body('Product still has stock. Stock must be 0 to deactivate.')
                                ->send();
                            return;
                        }

                        $record->update(['is_active' => false]);

                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Product deactivated successfully')
                            ->send();
                    })
                    ->visible(fn(Product $record) => $record->is_active),
                DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->placeholder('All status')
                    ->default(null)
                    ->query(function ($query, array $data) {
                        $value = $data['value'] ?? null;

                        if ($value === null || $value === '') {
                            return $query;
                        }

                        $state = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

                        return $state === null ? $query : $query->where('is_active', $state);
                    }),

                Tables\Filters\TernaryFilter::make('stock')
                    ->label('Stock = 0')
                    ->placeholder('All products')
                    ->trueLabel('Only out of stock')
                    ->falseLabel('In stock')
                    ->default(null)
                    ->query(function ($query, array $data) {
                        $value = $data['value'] ?? null;

                        if ($value === null || $value === '') {
                            return $query;
                        }

                        $state = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

                        return match ($state) {
                            true => $query->where('stock', 0),
                            false => $query->where('stock', '>', 0),
                            default => $query,
                        };
                    }),
            ])
            ->defaultSort('name')
            ->searchable(['code', 'name']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
