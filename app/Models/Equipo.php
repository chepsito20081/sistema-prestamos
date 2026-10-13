<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo_inventario', 'descripcion', 'estado'];

    // Un equipo puede tener muchos préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}