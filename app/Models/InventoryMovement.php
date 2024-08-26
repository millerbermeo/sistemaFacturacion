<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;
    protected $table = 'inventory_movements';

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }
}
