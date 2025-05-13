<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class PetVaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pet',
        'id_vaccine',
        'id_medical_record',
        'date_administered',
    ];

    //Relacion con la mascota vacunada
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'id_pet');
    }
    //Relacion con la vacuna administrad
    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'id_vaccine');
    }
    //Relacion con la cita cuando se administro
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'id_medical_record');
    }

}
