<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urls extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'id',
        'origin_url',
        'short_url',
        'created_at'
    ];
}
