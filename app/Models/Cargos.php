<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargos extends Model
{
    protected $table = 'cargo'; // Nombre de la tabla en la base de datos
    protected $fillable = ['descripcion']; // Columnas que se pueden asignar de forma masiva
}
