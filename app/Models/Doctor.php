<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{

    use Translatable;
    use HasFactory;
    public $translatedAttributes = ['name'];
    public $fillable = ['email', 'email_verified_at', 'password', 'phone', 'name', 'section_id', 'status'];


    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // One To One get section of Doctor
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    // many to many for doctor and appointment
    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_doctor');
    }


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
