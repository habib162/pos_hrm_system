<?php

namespace Modules\POS\App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'pos_suppliers';

    protected $fillable = [
        'name', 'company', 'email', 'phone', 'address', 'city', 'country', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }
}
