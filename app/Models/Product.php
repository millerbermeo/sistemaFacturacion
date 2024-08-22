<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'nombre', 'descripcion', 'precio', 'stock', 'id_categoria', 'url_imagen'
    ];

    // Relación muchos a uno con la categoría
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_categoria');
    }

    // Relación uno a muchos con los items de pedido
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'id_producto');
    }

    // Relación uno a muchos con las reseñas
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'id_producto');
    }
}
