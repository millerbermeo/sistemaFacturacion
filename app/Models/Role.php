<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
    ];

    // Opcional: desactivar incremento automático si usas otro tipo de clave primaria
    public $incrementing = true;

    // Opcional: especificar el tipo de clave primaria
    protected $keyType = 'int';

    // Relación con otras tablas (ejemplo de relación muchos a muchos)
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}
