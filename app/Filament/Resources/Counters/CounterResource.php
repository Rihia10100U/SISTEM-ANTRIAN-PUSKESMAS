<?php

namespace App\Filament\Resources\Counters;

use App\Filament\Resources\Counters\Pages\ManageCounters;
use App\Models\Counter;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
 

class CounterResource extends Resource
{
    protected static ?string $model = Counter::class;

    protected static ?string $navigationLabel = 'Konter';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;
    
    protected static string|UnitEnum|null $navigationGroup = 'Administrasi';

    public static function form(Schema $schema): Schema

    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('service_id')
                    ->required()
                    ->relationship('service', 'name'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('service_id')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCounters::route('/'),
        ];
    }
}