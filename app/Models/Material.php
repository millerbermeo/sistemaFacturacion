<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';
    protected $primaryKey = 'id_material';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_materials', 'id_material', 'id_producto')
            ->withPivot('cantidad')
            ->withTimestamps();
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class, 'id_material', 'id_material');
    }
}
