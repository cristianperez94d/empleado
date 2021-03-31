<?php

namespace App\Models;

use App\Models\EmpleadoRol;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
    use HasFactory;

    public function empleadosRoles(){
        return $this->hasMany(EmpleadoRol::class);
    }
}
