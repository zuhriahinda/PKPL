<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class, 'perangkat_daerah_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function canAcceptOrReject()
    {
        return auth()->user()->hasRole('super_admin');
    }
    
    protected static function boot()
    {
        parent::boot();
    
        static::updated(function ($program) {
            // Check if status_id or keterangan is dirty, to prevent unnecessary updates
            if ($program->isDirty('status_id') || $program->isDirty('keterangan')) {
                return;
            }
    
            // Use DB transaction to avoid infinite loops
            DB::transaction(function () use ($program) {
                // Avoid saving in the event of another transaction
                if ($program->getOriginal('status_id') != $program->status_id || $program->getOriginal('keterangan') != $program->keterangan) {
                    return;
                }
    
                // Ubah status dan keterangan
                $program->status_id = 2;
                $program->keterangan = 'Program telah diubah dan menunggu persetujuan.';
                $program->saveQuietly(); // Save without firing events
            });
        });
    }    

}
