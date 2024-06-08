<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ChartOrder extends ChartWidget
{
    protected static ?string $heading = 'Orderan Masuk';

    protected static string $color = 'success';

    protected function getData(): array
    {
        $data = Trend::model(Order::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Orderan masuk',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->aggregate),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
