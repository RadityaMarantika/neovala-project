<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterRegion extends Model
{
    protected $fillable = ['kode_region', 'nama_apart'];

    public function units()
    {
        return $this->hasMany(MasterUnit::class, 'region_id');
    }
}
