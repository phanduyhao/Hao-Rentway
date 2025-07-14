<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Baidang extends Model
{
    use HasFactory;

    protected $table= 'baidangs';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }


    public function address() {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function lienhes()
    {
        return $this->hasMany(BaidangLienhe::class);
    }

    public function nhadat()
    {
        return $this->belongsTo( Loainhadat::class, 'loainhadat_id','id');
    }
    public function lienhe()
    {
        return $this->belongsTo( Baidanglienhe::class, 'lienhe_id','id');
    }
    public function baidangchitiet()
    {
        return $this->belongsTo( BaidangChitiet::class, 'baidangchitiet_id','id');
    }
}
