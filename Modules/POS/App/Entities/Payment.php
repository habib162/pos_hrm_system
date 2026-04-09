<?php

namespace Modules\POS\App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'pos_payments';

    protected $fillable = ['sale_id', 'amount', 'method', 'reference'];

    protected $casts = ['amount' => 'decimal:2'];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
