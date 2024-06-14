<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ReadOnly;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;

use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationLabel = 'Order';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationGroup = 'Kasir';

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
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
