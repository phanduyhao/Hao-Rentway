<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\Baidang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $table="addresses";

    public function ward() {
        return $this->belongsTo(Ward::class, 'ward_id');
    }
    public function baidangs()
    {
        return $this->hasMany(Baidang::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

}
