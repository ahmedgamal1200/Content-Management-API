<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // إذا كان اسم الجدول في قاعدة البيانات مختلفًا عن الجمع الافتراضي للاسم
    protected $table = 'tags';

    // تحديد الأعمدة القابلة للتعبئة (Mass Assignment)
    protected $fillable = [
        'name',
    ];
}
