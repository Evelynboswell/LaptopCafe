<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_warranty';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_warranty',
        'id_service',
        'start_date',
        'warranty_duration',
        'end_date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}
