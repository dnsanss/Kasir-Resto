<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pemasok;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use OpenSpout\Common\Entity\Comment\TextRun;
use App\Filament\Resources\PemasokResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PemasokResource\RelationManagers;

class PemasokResource extends Resource
{
    protected static ?string $model = Pemasok::class;

    protected static ?string $navigationLabel = 'Barang Masuk';

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Pemasok')
                    ->schema([
                        TextInput::make('nama_pemasok')
                            ->label('Nama Pemasok')
                            ->required(),
                        TextInput::make('alamat')
                            ->label('Alamat Pemasok')
                            ->required(),
                        TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->required(),
                        TextInput::make('jumlah_barang')
                            ->label('Jumlah Barang')
                            ->numeric()
                            ->required(),
                        TextInput::make('telpon')
                            ->label('Nomor Telepon')
                            ->numeric()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pemasok')
                    ->label('Nama Pemasok')
                    ->searchable(),
                TextColumn::make('alamat')
                    ->label('Alamat Pemasok')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    })
                    ->searchable(),
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),
                TextColumn::make('jumlah_barang')
                    ->label('Jumlah Barang')
                    ->numeric()
                    ->searchable(),
                TextColumn::make('telpon')
                    ->label('Nomor Telepon')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPemasoks::route('/'),
            'create' => Pages\CreatePemasok::route('/create'),
            'view' => Pages\ViewPemasok::route('/{record}'),
            'edit' => Pages\EditPemasok::route('/{record}/edit'),
        ];
    }
}
