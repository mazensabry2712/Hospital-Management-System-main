<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;


class Appointment extends Model
{
    use Translatable;
    use HasFactory;
    public $translatedAttributes = ['name'];
    public $fillable = ['name'];

    // many to many for doctor and appointment
    // public function doctors() {
    //     return $this->belongsToMany(Doctor::class, 'appointment_doctor');
    // }

    // public function section()
    // {
    //     return $this->belongsTo(Section::class, 'section_id');
    // }
}
