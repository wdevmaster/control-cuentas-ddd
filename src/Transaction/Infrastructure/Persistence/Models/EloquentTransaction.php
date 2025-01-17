<?php

namespace Bank\Transaction\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentTransaction extends Model
{
    protected $table = 'transactions';

    public $timestamps = false;

    protected $fillable = [
        'account_id',
        'type',
        'amount',
        'description',
        'created_at'
    ];

    protected $casts = [
        'amount' => 'float',
        'created_at' => 'datetime',
    ];
}
