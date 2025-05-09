<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Veterinary extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'collegiate_num',
        'specialty',
    ];

   //Relacion con la clase usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    //Relacion de las citas que atiende el veterinario
    public function appointments() {
        return $this->hasMany(Appointment::class, 'id_veterinary');
    }

    //Un veterinario ha atendido varias citas
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'id_veterinary');
    }
}
