<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'id_usuario', 'total', 'estado_pedido'
    ];

    // Relación muchos a uno con el usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    // Relación uno a muchos con los items de pedido
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'id_pedido');
    }

    // Relación uno a muchos con los pagos
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'id_pedido');
    }
}
