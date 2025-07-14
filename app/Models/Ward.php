<?php

namespace App\Models;

use App\Models\District;
use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
    use HasFactory;
    protected $table="wards";

    public function district() {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function baidangs()
    {
        return $this->hasManyThrough(Baidang::class, Address::class, 'ward_id', 'address_id');
    }

}
