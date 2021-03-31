<?php

namespace App\Models;

use App\Models\Area;
use App\Models\EmpleadoRol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'nombre',
        'email',
        'sexo',
        'area_id',
        'boletin',
        'descripcion',
    ];

    public function empleadosRoles(){
        return $this->hasMany(EmpleadoRol::class);
    }
    public function area(){
        return $this->belongsTo(Area::class);
    }
}
