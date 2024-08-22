<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';
    protected $primaryKey = 'id_metodo_pago';

    protected $fillable = [
        'nombre_metodo'
    ];

    // Relación uno a muchos con los pagos
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'id_metodo_pago');
    }
}
