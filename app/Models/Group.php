<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use Translatable;
    use HasFactory;
    public $translatedAttributes = ['name', 'notes'];
    public $fillable = ['total_before_discount', 'discount_value', 'total_after_discount', 'tax_rate', 'total_with_tax', 'name', 'notes'];

    public function service_group()
    {
        return $this->belongsToMany(Service::class, 'group_service')->withPivot('quantity');
    }
}
