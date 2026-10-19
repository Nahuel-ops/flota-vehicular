<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Repuesto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'marca'];

    //  Relación inversa de Muchos a Muchos con Mantenimientos
    public function mantenimientos(): BelongsToMany
    {
        return $this->belongsToMany(Mantenimiento::class, 'mantenimiento_repuesto')
                    ->withPivot('cantidad', 'precio')
                    ->withTimestamps();
    }
}