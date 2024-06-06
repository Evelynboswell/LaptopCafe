<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'invoice_number',
        'entry_date',
        'takeout_date',
        'technician_id',
        'customer_id',
        'laptop_id',
        'problem_description',
        'service_ids',
        'total_price',
        'warranty_id',
        'status'
    ];

    protected $casts = [
        'service_ids' => 'array',
    ];
     public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function laptop()
    {
        return $this->belongsTo(Laptop::class, 'laptop_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_transaction_service', 'service_transaction_id', 'service_id');
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class, 'warranty_id');
    }
}
