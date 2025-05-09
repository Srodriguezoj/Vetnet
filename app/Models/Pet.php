<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_owner',
        'num_microchip',
        'name',
        'date_of_birth',
        'sex',
        'species',
        'breed',
        'colour',
        'coat',
        'size',
        'weight',
    ];
     
     protected $dates = ['date_of_birth'];
     
    //Relacion con el propietario de la mascota
    public function owner()
    {
        return $this->belongsTo(User::class, 'id_owner');
    }

    //Relacion con las citas de la mascota
    public function appointments() {
        return $this->hasMany(Appointment::class, 'id_pet');
    }

    //Una mascota tiene varios registros de citas
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'id_pet');
    }
}
