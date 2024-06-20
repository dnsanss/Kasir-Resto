<?php

namespace App\Filament\Kasir\Resources\OrderResource\Pages;

use App\Filament\Kasir\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
