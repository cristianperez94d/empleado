<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if($exception instanceof NotFoundHttpException ){ 
            if ($request->wantsJson()) {
                return $this->errorResponse('El endpoint que intenta acceder no existe', 404);
            }
            else{
                return parent::render($request, $exception);
            }
        }
        if($exception instanceof RouteNotFoundException){
            // delete this line of code in case of implementing the login            
            return Redirect::to('/404'); 
        }

        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('El metodo especificado para la peticion no es valido', 405);
        }
        
        if($exception instanceof ValidationException){
            return $this->errorResponse($exception->validator->errors(), 403);
        }

        if($exception instanceof QueryException){
            $codigo = $exception->errorInfo[1];
            
            if($codigo == 1451){
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso porque esta relacionado con algun otro recurso', 409);
            }
            if($codigo == 1062){
                return $this->errorResponse('El identificador ya existe', 409);
            }
        }
        if($exception instanceof ModelNotFoundException){
            $model = class_basename($exception->getModel());
            return $this->errorResponse("No existe ninguna instancia de {$model}", 404);
        }
        
        if(config('app.debug')){
            return parent::render($request, $exception);
        }
        return $this->errorResponse('Falla inesperada. Intente mas tarde.', 500);
    }

    private function errorResponse($message, $code){
        return response()->json(['error' => $message , 'code' => $code] ,$code);
    }
}
