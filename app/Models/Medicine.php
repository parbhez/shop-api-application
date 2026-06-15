<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'generic_name',
        'strength',
        'category',
        'brand',
        'price',
        'strip_price',
        'availability_status',
        'thumbnail',
    ];

    public function alternatives()
    {
        return $this->hasMany(MedicineAlternative::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
