<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Status;
use App\Models\Program;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\PerangkatDaerah;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProgramResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProgramResource\RelationManagers;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
                Forms\Components\Select::make('status_id')
                    ->label('Status')
                    ->options(Status::pluck('nama', 'id'))
                    ->default(1)
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('program')
                    ->required(),
                Forms\Components\TextInput::make('tahun')
                    ->required(),
                Forms\Components\TextInput::make('file_bukti')
                    ->url()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program')->searchable(),
                Tables\Columns\TextColumn::make('tahun')->searchable(),
                Tables\Columns\TextColumn::make('file_bukti')
                ->url(fn ($record) => $record->file_bukti ? $record->file_bukti : null)
                ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan'),
                Tables\Columns\TextColumn::make('status.nama')
                ->label('Status')
                ->label('Status')
                ->badge() // Mengaktifkan tampilan badge
                ->colors([
                    'primary' => fn ($state) => $state === 'Draft',
                    'success' => fn ($state) => $state === 'Disetujui',
                    'danger' => fn ($state) => $state === 'Ditolak',
                    'warning' => fn ($state) => $state === 'Updated',
                ])
                ->icon(fn ($state) => match ($state) {
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
                Tables\Filters\Filter::make('My Program')
                ->query(fn (Builder $query) => auth()->check() && auth()->user()->hasRole('panel_user')
                    ? $query->where('user_id', auth()->id())
                    : $query->whereRaw('1 = 0')
                )
                ->visible(fn () => auth()->check() && auth()->user()->hasRole('panel_user'))
                ->default(fn () => auth()->check() && auth()->user()->hasRole('panel_user') ? 'active' : null),
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
                ->action(function ($data,$record){
                    $record->status_id = '4';
                    $record->keterangan = $data['keterangan'];
                    $record->save();
                })->form([
                    Forms\Components\TextArea::make('keterangan')
                        ->required(),  
                ])
                ->visible(fn ($record) => $record->canAcceptOrReject()),
                //Tables\Actions\Action::make('Draft')
                //->action(function ($record){
                //    $record->status_id = '1';
                //    $record->save();
                //}),
                Tables\Actions\Action::make('Terima')
                ->action(function ($record){
                    $record->status_id = '3';
                    $record->keterangan = 'Disetujui';
                    $record->save();
                })
                ->visible(fn ($record) => $record->canAcceptOrReject()),
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
