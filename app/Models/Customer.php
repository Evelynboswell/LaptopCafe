<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'customer_phone_number',
    ];
    public function laptops()
    {
        return $this->hasMany(Laptop::class, 'customer_id', 'customer_id');
    }
}
