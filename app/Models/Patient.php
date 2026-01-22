<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use Translatable;
    use HasFactory;
    public $translatedAttributes = ['name', 'gender', 'address'];
    public $fillable = ['email', 'password', 'date_birth', 'phone', 'gender', 'blood_group', 'name', 'address'];

    public function doctor()
    {
        return $this->belongsTo(Invoice::class, 'doctor_id');
    }

    public function service()
    {
        return $this->belongsTo(Invoice::class, 'service_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
