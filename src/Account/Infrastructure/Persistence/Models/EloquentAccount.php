<?php

namespace Bank\Account\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentAccount extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'account_name',
        'account_number',
        'currency',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'currency' => 'string',
    ];
}
