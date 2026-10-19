<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chofer extends Model
{
    use HasFactory;

    // Laravel busca la tabla en inglés por defecto, la obligamos a usar el español
    protected $table = 'choferes';

    protected $fillable = ['nombre', 'licencia', 'telefono'];

    // Un chofer tiene muchos vehículos
    public function vehiculos(): HasMany
    {
        return $this->hasMany(Vehiculo::class);
    }
}
