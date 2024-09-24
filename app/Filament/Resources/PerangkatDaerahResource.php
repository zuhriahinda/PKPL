<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerangkatDaerahResource\Pages;
use App\Filament\Resources\PerangkatDaerahResource\RelationManagers;
use App\Models\PerangkatDaerah;
use App\Models\Status;
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
                Forms\Components\Select::make('status_id')
                    ->label('Status')
                    ->options(Status::pluck('nama', 'id'))
                    ->default(1)
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan'),
                Tables\Columns\TextColumn::make('status.nama')
                    ->label('Status')
                    ->label('Status')
                    ->badge() // Mengaktifkan tampilan badge
                    ->colors([
                        'primary' => fn($state) => $state === 'Draft',
                        'success' => fn($state) => $state === 'Disetujui',
                        'danger' => fn($state) => $state === 'Ditolak',
                        'warning' => fn($state) => $state === 'Updated',
                    ])
                    ->icon(fn($state) => match ($state) {
                        'Draft' => 'heroicon-o-pencil',
                        'Disetujui' => 'heroicon-o-check-circle',
                        'Ditolak' => 'heroicon-o-x-circle',
                        'Updated' => 'heroicon-o-clock',
                        default => null,
                    })
                    ->iconPosition('before')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->action(function ($data, $record) {
                        // Update data program
                        $record->update($data);

                        // Menandai program dengan status setelah diedit
                        $record->status_id = 2; // Status 2 menandakan sudah diubah
                        $record->keterangan = 'Program telah diubah, menunggu tindakan selanjutnya';
                        $record->save();
                    }),
                Tables\Actions\Action::make('tolak')
                    ->action(function ($data, $record) {
                        $record->status_id = '4';
                        $record->keterangan = $data['keterangan'];
                        $record->save();
                    })->form([
                        Forms\Components\TextArea::make('keterangan')
                            ->required(),
                    ])
                    ->visible(fn($record) => $record->canAcceptOrReject()),
                //Tables\Actions\Action::make('Draft')
                //->action(function ($record){
                //    $record->status_id = '1';
                //    $record->save();
                //}),
                Tables\Actions\Action::make('Terima')
                    ->action(function ($record) {
                        $record->status_id = '3';
                        $record->keterangan = 'Disetujui';
                        $record->save();
                    })
                    ->visible(fn($record) => $record->canAcceptOrReject()),
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
