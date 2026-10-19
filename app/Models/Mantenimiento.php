<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $fillable = ['vehiculo_id', 'tipo', 'fecha', 'kilometraje', 'taller', 'costo_total'];

    // Un mantenimiento pertenece a un Vehículo
    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class);
    }

    // Relación de Muchos a Muchos con Repuestos (Inyectando cantidad y precio de la tabla intermedia)
    public function repuestos(): BelongsToMany
    {
        return $this->belongsToMany(Repuesto::class, 'mantenimiento_repuesto')
                    ->withPivot('cantidad', 'precio')
                    ->withTimestamps();
    }
}

