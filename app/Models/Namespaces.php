<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Namespaces extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'id',
        'member_id',
        'name'
    ];
}
