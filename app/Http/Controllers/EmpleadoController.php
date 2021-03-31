<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\EmpleadoRol;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class EmpleadoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(Empleado::with('area')->get());
    }

    public function consultAreas()
    {
        return $this->showAll(Area::all());
    }

    public function consultRoles()
    {
        return $this->showAll(Rol::all());
    }

    public function consultEmpleadoRoles($id)
    {
        $empleado = Empleado::findOrFail($id);
        $roles = $empleado->empleadosRoles()->get(); 

        return $this->showAll($roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $reglas = [
            'empleado.nombre' => ['required', 'regex:/^[a-zA-ZñÑáéíóúáéíóúÁÉÍÓÚ\s]+$/'],
            'empleado.email' => ['required', 'email'],
            'empleado.sexo' => ['required'],
            'empleado.area_id' => ['required','integer'],
            'empleado.descripcion' => ['required'],
            'roles' => ['required'],
        ];

        
        // validar datos
        $request->validate($reglas);

        // crear la empleado
        $empleado = Empleado::create($request->empleado);
        // insertar roles empleado
        foreach ($request->roles as $key => $value) {
            EmpleadoRol::create(['rol_id' => $value, 'empleado_id' => $empleado->id]);
        }
        
        return $this->showOne($empleado, 201, 'Registro creado correctamente...');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        return $this->showOne($empleado);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        $reglas = [
            'empleado.nombre' => ['required', 'regex:/^[a-zA-ZñÑáéíóúáéíóúÁÉÍÓÚ\s]+$/'],
            'empleado.email' => ['required', 'email'],
            'empleado.sexo' => ['required'],
            'empleado.area_id' => ['required','integer'],
            'empleado.descripcion' => ['required'],
            'roles' => ['required'],
        ];

        
        // validar datos
        $request->validate($reglas);

        if($request->has('empleado.nombre')){
            $empleado->nombre = $request->empleado['nombre'];
        }
        if($request->has('empleado.email')){
            $empleado->email = $request->empleado['email'];
        }
        if($request->has('empleado.sexo')){
            $empleado->sexo = $request->empleado['sexo'];
        }
        if($request->has('empleado.area_id')){
            $empleado->area_id = $request->empleado['area_id'];
        }
        if($request->has('empleado.descripcion')){
            $empleado->descripcion = $request->empleado['descripcion'];
        }

        // comparar si hay actulizacion de roles
        if($request->has('roles')){
            $empleadoRoles = EmpleadoRol::where('empleado_id', '=', $empleado->id)->get();
            $arrayRoles = $empleadoRoles->map(function ($item) {
                return $item->rol_id;
            });
            $diffEliminar = []; 
            $diffInsertar = []; 
            $collectionRequestRoles = collect($request->roles);
            if(!$arrayRoles->isEmpty()){
                // eliminar los diferentes
                $diffEliminar = $arrayRoles->diff($collectionRequestRoles);
                $diffEliminar = $diffEliminar->all();
            }
            // insertar los roles que llegan y son diferentes
            $diffInsertar = $collectionRequestRoles->diff($arrayRoles);
            $diffInsertar = $diffInsertar->all();   
            // dd(["insertar"=>$diffInsertar, 'Eliminar'=>$diffEliminar]);
        }

        if(!$empleado->isDirty() 
        && count($diffInsertar) === 0 
        && count($diffEliminar) ===0 
        ){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        // inserta roles de empleado
        foreach ($diffInsertar as $key => $value) {
            EmpleadoRol::create(['rol_id' => $value, 'empleado_id' => $empleado->id]);
        }
        // eliminar roles de empleado
        foreach ($diffEliminar as $key => $value) {
            DB::table('empleado_rols')->where('empleado_id', '=', $empleado->id)
            ->where('rol_id', '=', $value)->delete();
        }
        // guardar empleado
        $empleado->save();

        return $this->showOne($empleado, 200, "Registro actualizado correctamente...");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return $this->showOne($empleado, 200, "Empleado eliminado correctamente..");
    }
}
