<?php

namespace App\Filament\Kasir\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Kasir\Resources\OrderResource\Pages;
use App\Filament\Kasir\Resources\OrderResource\RelationManagers;
use Filament\Infolists\Components\Section as ComponentsSection;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationLabel = 'Order';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Pesanan')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Pembeli')
                            ->required(),
                        Select::make('produk_id')
                            ->label('Nama Produk')
                            ->relationship(name: 'Produk', titleAttribute: 'nama_produk')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $produk = \App\Models\Produk::find($state);
                                if ($produk) {
                                    $set('harga', $produk->harga);
                                    $set('total_harga', $produk->harga);
                                }
                            }),
                        TextInput::make('harga')
                            ->readOnly()
                            ->numeric()
                            ->label('Harga')
                            ->required(function ($state) {
                                return $state ? number_format($state, 2) : '';
                            })
                            ->default(0),
                        TextInput::make('quantity')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $produkHarga = $get('harga');
                                $set('total_harga', $produkHarga * $state);
                            })
                            ->numeric()
                            ->required(),
                        TextInput::make('total_harga')
                            ->label('Total Harga')
                            ->readOnly()
                            ->numeric()
                            ->default(function ($data) {
                                return $data['total_harga'] ? number_format($data['total_harga'], 2) : '';
                            })
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Pembeli')
                    ->searchable(),
                TextColumn::make('Produk.nama_produk')
                    ->label('Nama Produk')
                    ->searchable(),
                TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Pembelian')
                    ->dateTime()
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Info Order')
                    ->schema([
                        TextEntry::make('nama'),
                        TextEntry::make('Produk.nama_produk'),
                        TextEntry::make('harga')
                            ->label('Harga Produk')
                            ->money('IDR'),
                        TextEntry::make('quantity')
                            ->label('Jumlah yang Dibeli'),
                        TextEntry::make('total_harga')
                            ->label('Total Harga')
                            ->money('IDR'),
                        TextEntry::make('created_at')
                    ])
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
