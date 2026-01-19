<?php

namespace App\Filament\Resources;

// --- UPDATE KHUSUS FILAMENT V4 ---
use Filament\Schemas\Schema; 
use Filament\Resources\Resource;

use UnitEnum;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\QueueResource\Pages;
use App\Filament\Resources\QueueResource\RelationManagers;
use App\Models\Queue;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QueueResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $label = 'Antrian';

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static UnitEnum|string|null $navigationGroup = 'Administrasi';

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canUpdate(): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canViewAny(): bool
{
    // Pastikan user admin bisa melihat menu ini di sidebar
    return auth()->user()->role === 'admin'; 
}

    // --- PERBAIKAN DI SINI (Menggunakan Schema) ---
    public static function form(Schema $schema): Schema
    {
        return $schema // Perhatikan variabel ini sekarang $schema, bukan $form
            ->schema([
                Forms\Components\TextInput::make('service_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('counter_id')
                    ->numeric(),
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('waiting'),
                Forms\Components\DateTimePicker::make('called_at'),
                Forms\Components\DateTimePicker::make('served_at'),
                Forms\Components\DateTimePicker::make('canceled_at'),
                Forms\Components\DateTimePicker::make('finished_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('counter_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('called_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('served_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('canceled_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('finished_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tambahkan prefix Tables\Actions\ agar tidak error class not found
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQueues::route('/'),
        ];
    }
}