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

   
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
