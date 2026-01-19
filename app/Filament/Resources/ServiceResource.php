<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema; 
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;

// --- PERBAIKAN DI SINI: Import Action secara spesifik ---
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationLabel = 'Layanan';

    // Pastikan class Heroicon ini tersedia, jika error ganti string icon biasa
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static UnitEnum|string|null $navigationGroup = 'Administrasi';

    // Perbaikan: Menggunakan Schema, bukan Form
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([ // Gunakan ->schema(), bukan ->components() untuk standar umum
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('prefix')
                    ->required(),
                Forms\Components\TextInput::make('padding')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prefix')
                    ->searchable(),
                Tables\Columns\TextColumn::make('padding')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            // Perbaikan: Gunakan ->actions(), bukan ->recordActions()
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            // Perbaikan: Gunakan ->bulkActions(), bukan ->toolbarActions() untuk BulkActionGroup
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageServices::route('/'),
        ];
    }

    public static function canViewAny(): bool
{
    // Pastikan user admin bisa melihat menu ini di sidebar
    return auth()->user()->role === 'admin'; 
}
}