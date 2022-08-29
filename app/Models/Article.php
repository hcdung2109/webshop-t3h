<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // định nghĩa quan hệ CSDL
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
