<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_pedido', 'id_metodo_pago', 'monto', 'fecha_pago'
    ];

    // Relación muchos a uno con el pedido
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_pedido');
    }

    // Relación muchos a uno con el método de pago
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'id_metodo_pago');
    }
}
