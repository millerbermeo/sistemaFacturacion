<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $primaryKey = 'id_item_pedido';

    protected $fillable = [
        'id_pedido', 'id_producto', 'cantidad', 'precio'
    ];

    // Relación muchos a uno con el pedido
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_pedido');
    }

    // Relación muchos a uno con el producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }
}
