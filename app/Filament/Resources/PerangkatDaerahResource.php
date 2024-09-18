<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerangkatDaerahResource\Pages;
use App\Filament\Resources\PerangkatDaerahResource\RelationManagers;
use App\Models\PerangkatDaerah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PerangkatDaerahResource extends Resource
{
    protected static ?string $model = PerangkatDaerah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->searchable();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerangkatDaerahs::route('/'),
            'create' => Pages\CreatePerangkatDaerah::route('/create'),
            'edit' => Pages\EditPerangkatDaerah::route('/{record}/edit'),
        ];
    }
}
