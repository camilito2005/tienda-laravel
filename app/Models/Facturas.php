<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facturas extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $fillable = ['producto_id', 'stock', 'precio', 'total', 'fecha', 'cliente_correo'];
    
    public $timestamps = false; // Si tu tabla no tiene columnas `created_at` y `updated_at`

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
