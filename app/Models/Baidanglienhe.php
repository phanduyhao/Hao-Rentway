<?php

namespace App\Models;

use App\Models\Baidang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Baidanglienhe extends Model
{
    use HasFactory;
    protected $table="baidang_lienhes";

    public function baidang()
    {
        return $this->belongsTo(Baidang::class);
    }
}
