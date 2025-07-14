<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thietbi extends Model
{
    protected $table ='thietbis';
    protected $fillable = ['title', 'icon'];
}
