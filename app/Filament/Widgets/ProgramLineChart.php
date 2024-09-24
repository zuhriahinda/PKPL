<?php

namespace App\Filament\Widgets;

use App\Models\PerangkatDaerah;
use Filament\Widgets\ChartWidget;

class ProgramLineChart extends ChartWidget
{
    protected static ?string $heading = 'Pratinjau Program';

    protected function getData(): array
    {
        // Mengambil data program dengan menghitung jumlah berdasarkan bulan
        $programs = PerangkatDaerah::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Membuat array bulan dengan data default 0
        $months = range(1, 12);
        $counts = array_fill(1, 12, 0);

        // Menyusun data dari database ke array counts
        foreach ($programs as $program) {
            $month = $program->month;
            $counts[$month] = $program->count;
        }

        return [
            'labels' => array_map(fn($m) => \DateTime::createFromFormat('!m', $m)->format('F'), $months), // Nama bulan
            'datasets' => [
                [
                    'label' => 'Jumlah Program',
                    'data' => array_values($counts), // Jumlah program berdasarkan bulan
                    'borderColor' => 'rgba(75, 192, 192, 1)', // Warna garis
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Warna background
                    'pointBackgroundColor' => 'rgba(75, 192, 192, 1)', // Warna titik data
                    'pointBorderColor' => '#fff', // Warna border titik data
                    'pointHoverBackgroundColor' => '#fff', // Warna titik saat hover
                    'pointHoverBorderColor' => 'rgba(75, 192, 192, 1)', // Warna border titik saat hover
                    'borderWidth' => 2,
                    'fill' => true,
                    'lineTension' => 0.1, // Mengatur kelengkungan garis
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Menggunakan line chart
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
                        'text' => 'Bulan',
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
                    'display' => true,
                    'position' => 'top',
                    'labels' => [
                        'font' => [
                            'size' => 14,
                            'family' => 'Arial, sans-serif',
                        ],
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'backgroundColor' => 'rgba(0, 0, 0, 0.7)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff',
                    'borderColor' => '#fff',
                    'borderWidth' => 1,
                    'padding' => 10,
                    'cornerRadius' => 4,
                ],
            ],
        ];
    }
}
