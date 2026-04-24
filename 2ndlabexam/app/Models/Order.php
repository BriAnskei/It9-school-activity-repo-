<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'rice_id', 'quantity', 'total_price', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rice(): BelongsTo
    {
        return $this->belongsTo(Rice::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}