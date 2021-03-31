<?php

namespace App\Models;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
    ];
    
    public function empleados(){
        return $this->hasMany(Empleado::class);
    }
}
