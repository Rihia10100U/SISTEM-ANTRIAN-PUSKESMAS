<?php

namespace App\Filament\Resources;

// --- UPDATE KHUSUS FILAMENT V4 ---
use Filament\Schemas\Schema; 
use Filament\Resources\Resource;

use UnitEnum;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Pengguna';

    // Pastikan Heroicon valid, jika error ganti string biasa
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static UnitEnum|string|null $navigationGroup = 'Administrasi';

    // Perbaikan: Menggunakan Schema, bukan Form
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([ // Gunakan ->schema(), bukan ->components()
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required() // Hapus required() jika ini form edit, atau buat conditional
                    ->visibleOn('create'), // Opsional: biasanya password hanya wajib saat create
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
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
            // Perbaikan: Gunakan ->bulkActions(), bukan ->toolbarActions()
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            // Perbaikan: Tambahkan prefix Pages\ agar sesuai import di atas
            'index' => Pages\ManageUsers::route('/'),
        ];
    }

    public static function canViewAny(): bool
{
    // Pastikan user admin bisa melihat menu ini di sidebar
    return auth()->user()->role === 'admin'; 
}
}