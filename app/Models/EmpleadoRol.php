<?php

namespace App\Models;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmpleadoRol extends Model
{
    use HasFactory;

    protected $fillable = [
        'rol_id',
        'empleado_id'
    ];

    public function empleado(){
        return $this->belongsTo(Empleado::class);
    }
    public function rol(){
        return $this->belongsTo(Rol::class);
    }
}
