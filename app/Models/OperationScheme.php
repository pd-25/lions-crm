<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationScheme extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'slug'];
}
