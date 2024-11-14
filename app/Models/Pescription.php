<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pescription extends Model
{
    use HasFactory;
    protected $fillable = ["register_booking_id", "venue", "guardians_name", "age", "sex", "doctor", "clinical_findings", "advice"];
}
