<?php

namespace App\Models;

use App\Models\Baidang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loainhadat extends Model
{
    use HasFactory;
    protected $table="loainhadats";

    protected $fillable = ['id','title', 'slug', 'icon'];

    public function baidangs()
    {
        return $this->hasMany(Baidang::class);
    }
}
