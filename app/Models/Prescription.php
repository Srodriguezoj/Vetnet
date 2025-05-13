<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
     use HasFactory;

    protected $fillable = [
        'medication',
        'dosage',
        'instructions',
        'duration',
    ];

    // Relación del id de la tabla MedicalRecord
    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'id_prescription');
    }
}
