<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipo_id',
        'user_id',
        'fecha_prestamo',
        'fecha_devolucion_esperada',
        'fecha_devolucion_real',
        'estado',
    ];

    // Un préstamo pertenece a un equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    // Un préstamo pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}