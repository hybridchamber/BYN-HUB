<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulletinBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'date_time',
        'bb_file'
    ];
}
