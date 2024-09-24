<?php

namespace App\Filament\Widgets;

use App\Models\Status;
use App\Models\PerangkatDaerah;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Ambil ID dari status 'Disetujui', 'Ditolak', dan 'Draft'
        $approvedStatusId = Status::where('nama', 'Disetujui')->value('id');
        $rejectedStatusId = Status::where('nama', 'Ditolak')->value('id');
        $draftStatusId = Status::where('nama', 'Draft')->value('id');
        $updateStatusId = Status::where('nama', 'Updated')->value('id');

        return [
            // Jumlah Program dengan Status 'Disetujui'
            Stat::make('Disetujui', PerangkatDaerah::where('status_id', $approvedStatusId)->count())
                ->description('Program yang Disetujui')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Updated', PerangkatDaerah::where('status_id', $updateStatusId)->count())
                ->description('Program yang telah diedit')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            // Jumlah Program dengan Status 'Ditolak'
            Stat::make('Ditolak', PerangkatDaerah::where('status_id', $rejectedStatusId)->count())
                ->description('Program yang Ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            // Jumlah Program dengan Status 'Draft'
            Stat::make('Draft', PerangkatDaerah::where('status_id', $draftStatusId)->count())
                ->description('Draft Program')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),
        ];
    }
}
