<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\ApiVisit;
use Carbon\Carbon;

class ApiVisitChartWidget extends BarChartWidget
{
    protected static ?string $heading = 'Page Visits';

    protected function getFilters(): ?array
    {
        return [
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }

    protected function getData(): array
    {
        $period = $this->filter ?? 'week';

        // Start- en einddatum berekenen
        switch ($period) {
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                break;
            case 'week':
            default:
                $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY);
                break;
        }

        $visits = ApiVisit::whereDate('visited_at', '>=', $startDate)
            ->selectRaw('visited_at, SUM(visit_count) as total')
            ->groupBy('visited_at')
            ->orderBy('visited_at')
            ->get();

        $backgroundColor = '#f97316';

        $barPercentage = count($visits) === 1 ? 0.5 : 0.8;

        return [
            'labels' => $visits->pluck('visited_at')->toArray(),
            'datasets' => [
                [
                    'label' => 'Visits',
                    'data' => $visits->pluck('total')->toArray(),
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => '#f97316',
                    'borderWidth' => 2,
                    'barPercentage' => $barPercentage,
                ],
            ],
        ];
    }
}