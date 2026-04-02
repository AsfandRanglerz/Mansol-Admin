<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDuplicateCnic extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'cnic',
        'count',
        'rows',
        'seen',
    ];
}
