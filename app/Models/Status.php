<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $table='status';

    public function programs():HasMany
    {
        return $this->HasMany(Status::class);
    }

    
}
