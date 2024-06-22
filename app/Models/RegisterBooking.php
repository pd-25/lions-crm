<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;
class RegisterBooking extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id','user_id', 'patient_name','phone_number','address','amount', 'about_patient_problem', 'booking_type_id', 'operation_scheme_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registerBooking) {
            $registerBooking->slug = static::generateUniqueSlug($registerBooking->patient->name);
        });
    }

    /**
     * Generate a unique slug for the user.
     *
     * @param  string  $name
     * @return string
     */
    protected static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (User::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bookingType(): BelongsTo
    {
        return $this->belongsTo(BookingType::class, 'booking_type_id', 'id');
    }

    public function operationScheme(): BelongsTo
    {
        return $this->belongsTo(OperationScheme::class, 'operation_scheme_id', 'id');
    }

    public function getBookingTypeOrOperationAttribute()
    {
        if (!empty($this->booking_type_id) && $this->booking_type_id != '') {
            return $this->bookingType->type_name;
        }
        return $this->operationScheme?->name.'<span class="text-danger">(Operation)</span>';
    }
    public function getCreatedAtAttribute($value)
    {
        // return Carbon::parse($value)->setTimezone(config('app.timezone'))->toDateTimeString();
        return Carbon::parse($value)->timezone('Asia/Kolkata')->toDateTimeString();
    }
}
