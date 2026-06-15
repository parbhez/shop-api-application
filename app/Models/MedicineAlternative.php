<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicineAlternative extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'medicine_id',
        'title',
        'generic_name',
        'strength',
        'brand',
        'price',
        'strip_price',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
