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

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'id_pet');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'id_vaccine');
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'id_medical_record');
    }

}
