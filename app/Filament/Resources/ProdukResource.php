<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produk;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use function Laravel\Prompts\textarea;
use Filament\Forms\Components\Textarea;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProdukResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProdukResource\RelationManagers;
use Filament\Infolists\Components\TextEntry;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Produk')
                    ->schema([
                        TextInput::make('nama_produk')
                            ->required(),
                        Select::make('kategori_id')
                            ->relationship(name: 'Kategori', titleAttribute: 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('harga')
                            ->numeric()
                            ->required(),
                        TextInput::make('stok')
                            ->numeric()
                            ->required(),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_produk')
                    ->searchable(),
                TextColumn::make('Kategori.nama')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('harga')
                    ->money('IDR')
                    ->searchable(),
                TextColumn::make('stok')
                    ->numeric()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\deleteAction::make(),
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'view' => Pages\ViewProduk::route('/{record}'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
