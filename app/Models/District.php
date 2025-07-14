<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    protected $table="districts";

    public function province() {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
}
