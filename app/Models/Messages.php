<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_client',
        'title',
        'subject',
        'date',
        'time',
        'status',
    ];
     // Relación con tabla cliente
    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }
}
