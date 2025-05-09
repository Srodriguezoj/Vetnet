<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
   use HasFactory;

    protected $fillable = [
        'id_pet',
        'id_veterinary',
        'date',
        'time',
        'title',
        'description',
        'state',
        'specialty',
    ];

    //Indica que la cita está relacionada con una mascota por su id
    public function pet() {
        return $this->belongsTo(Pet::class, 'id_pet');
    }

    //Indica que la cita está relacionada con un veterinario por su id
    public function veterinary() {
        return $this->belongsTo(Veterinary::class, 'id_veterinary');
    }

    //Cada cita tiene un registro vinculado
    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'id_appointment');
    }
}
