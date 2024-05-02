<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegisterBooking extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id','user_id', 'patient_name','phone_number','address','amount'];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
