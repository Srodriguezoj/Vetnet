<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_client',
        'id_veterinary',
        'date',
        'total',
        'tax_percentage',
        'total_with_tax',
        'status',
    ];

    //Relacion con la tabla cliente
    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }

    //Relacion con la tabla veterinario
    public function veterinary()
    {
        return $this->belongsTo(Veterinary::class, 'id_veterinary');
    }

    //Relacion con el registro de la cita
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'id_invoice');
    }

    //Relacion con los conceptos de la factura
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'id_invoice');
    }
}
