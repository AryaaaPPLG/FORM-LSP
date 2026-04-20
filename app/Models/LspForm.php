<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LspForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'asal_sekolah',
        'signature',
        'status',
    ];
}
