<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaidangChitiet extends Model
{
    use HasFactory;

    protected $table= 'baidang_chitiets';

    public function user()
    {
        return $this->belongsTo(Baidang::class,'baidang_id', 'id');
    }
}
