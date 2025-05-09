<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaccine_type',
        'stamp',
        'batch_num',
        'expedition_number',
    ];

    // Relación con las vacunaciones de las mascotas
    public function petVaccinations()
    {
        return $this->hasMany(PetVaccination::class, 'id_vaccine');
    }
}