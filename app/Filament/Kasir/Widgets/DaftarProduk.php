<?php

namespace App\Filament\Kasir\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\ProdukResource;
use Filament\Widgets\TableWidget as BaseWidget;

class DaftarProduk extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(ProdukResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->searchable(),
                TextColumn::make('Kategori.nama')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->searchable(),
                TextColumn::make('stok')
                    ->label('Stok Produk')
                    ->numeric()
                    ->searchable(),
                TextColumn::make('aktif')
                    ->label('Status Produk')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'AKTIF' => 'success',
                        'TIDAK AKTIF' => 'danger',
                    }),
            ]);
    }
}
