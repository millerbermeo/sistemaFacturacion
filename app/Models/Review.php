<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'id_resena';

    protected $fillable = [
        'id_producto', 'id_usuario', 'calificacion', 'comentario'
    ];

    // Relación muchos a uno con el producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }

    // Relación muchos a uno con el usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
}
