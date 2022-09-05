<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory,Filterable;

    protected $fillable = [
        'uuid',
        'user_email',
        'paid_amount',
        'currency',
        'status',
        'payment_date'
    ];

    protected $casts =
    [
        'payment_date' => 'datetime'
    ];


    public function user()
    {
        return $this->belongsTo(User::class ,'user_email','email');
    }
}
