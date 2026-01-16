<?php

namespace App\Filament\Resources\Queues;

use App\Filament\Resources\Queues\Pages\ManageQueues;
use App\Models\Queue;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;



class QueueResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationLabel = 'Antrian';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static string|UnitEnum|null $navigationGroup = 'Administrasi';

    public static function canCreate(): bool {
        return false;    }

    public static function canEdit($recard): bool {
        return false;    }
    
     public static function canUpdate(): bool {
        return false;    }

    public static function canDeleteAny(): bool {
        return false;    }

    public static function form(Schema $schema): Schema
    { return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('counter_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('number')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('called_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('served_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('canceled_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('finished_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => ManageQueues::route('/'),
        ];
    }
}
