<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = ['chofer_id', 'placa', 'marca', 'modelo', 'anio', 'kilometraje_actual'];

    //Un vehículo pertenece a un Chofer
    public function chofer(): BelongsTo
    {
        return $this->belongsTo(Chofer::class);
    }

    //Un vehículo tiene muchos mantenimientos
    public function mantenimientos(): HasMany
    {
        return $this->hasMany(Mantenimiento::class);
    }
}
