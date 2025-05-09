<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_invoice',
        'title',
        'description',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    //Relacion con la factura a la que pertenece
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'id_invoice');
    }
}
