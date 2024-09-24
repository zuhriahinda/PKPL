<?php

namespace App\Filament\Widgets;

use App\Models\Status;
use App\Models\PerangkatDaerah;
use Filament\Widgets\ChartWidget;

class ProgramChart extends ChartWidget
{
    protected static ?string $heading = 'Status Program';

    protected function getData(): array
    {
        $statuses = Status::all()->pluck('nama', 'id');
        $statusCounts = [
            'Draft' => 0,
            'Disetujui' => 0,
            'Updated' => 0,
            'Ditolak' => 0,
        ];

        foreach ($statuses as $statusId => $statusName) {
            if (array_key_exists($statusName, $statusCounts)) {
                $statusCounts[$statusName] = PerangkatDaerah::where('status_id', $statusId)->count();
            }
        }

        return [
            'labels' => array_keys($statusCounts), // Status sebagai label pada sumbu X
            'datasets' => [
                [
                    'label' => 'Jumlah Program',
                    'data' => array_values($statusCounts), // Jumlah untuk masing-masing status
                    'backgroundColor' => [
                        'rgb(0, 123, 255)',
                        'rgb(40, 167, 69)',
                        'rgb(255, 193, 7)',
                        'rgb(220, 53, 69)',
                    ],
                    'borderColor' => [
                        'rgb(0, 123, 255)',
                        'rgb(40, 167, 69)',
                        'rgb(255, 193, 7)',
                        'rgb(220, 53, 69)',
                    ],
                    'borderWidth' => 2,
                    'barPercentage' => 0.8, // Menyesuaikan lebar bar
                    'categoryPercentage' => 1.0,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Menggunakan bar chart
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'display' => false,
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Status',
                        'color' => '#333',
                        'font' => [
                            'size' => 12,
                            'family' => 'Arial, sans-serif',
                            'weight' => 'bold',
                        ],
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'display' => true,
                        'color' => '#ddd',
                    ],
                    'ticks' => [
                        'beginAtZero' => true,
                        'precision' => 0,
                        'font' => [
                            'size' => 14,
                            'family' => 'Arial, sans-serif',
                        ],
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Program',
                        'color' => '#333',
                        'font' => [
                            'size' => 12,
                            'family' => 'Arial, sans-serif',
                            'weight' => 'bold',
                        ],
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false, // Menonaktifkan legend
                ],
                'tooltip' => [
                    'enabled' => true,
                    'backgroundColor' => 'rgba(0, 0, 0, 0.7)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff',
                    'borderColor' => '#fff',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }
}
