<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
     use HasFactory;

    protected $fillable = [
        'id_pet',
        'id_veterinary',
        'id_appointment',
        'diagnosis',
        'id_prescription',
        'id_invoice',
    ];

    //Relaciona el registro de la cita con la mascota a la que pertenece
    public function pet() {
        return $this->belongsTo(Pet::class, 'id_pet');
    }

    //Relaciona el registro de la cita con el veterinario que atendio la cita
    public function veterinary() {
        return $this->belongsTo(Veterinary::class, 'id_veterinary');
    }

    //Relaciona el registro con la cita realizada
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'id_appointment');
    }

    
    //El registro de la cita tiene receta
    public function prescription() {
         return $this->belongsTo(Prescription::class, 'id_prescription');
    }

    // public function invoice() {
    //     return $this->belongsTo(Invoice::class, 'id_invoice');
    // }
}
