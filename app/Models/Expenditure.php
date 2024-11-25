<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expenditure extends Model
{
    use HasFactory;
    protected $fillable = ['ammount', 'debit_or_credit', 'note', 'date', 'unique_personal_doc_name', 'unique_personal_doc_id', 'id_code', 'section_code', 'name_of_donor', 'address_of_donor', 'donation_type', 'payment_mode', 'member_id'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
