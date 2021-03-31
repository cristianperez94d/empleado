<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class ApiController extends Controller
{
    private function successResponse($data, $code, $message){
        return response()->json(['response'=>$data, 'message'=>$message], $code);
    }

    protected function errorResponse($message, $code){
    return response()->json(['error' => $message , 'code' => $code] ,$code);
    }

    protected function showAll(Collection $collection, $code = 200, $message = "Ok"){
        
        if( $collection->isEmpty() ){
            return $this->successResponse(['data' => $collection], $code, $message);
        }        
        
        return $this->successResponse($collection, $code, $message);
    }
    
    protected function showOne(Model $instance, $code = 200, $message = "Ok"){   
        return $this->successResponse($instance, $code, $message);
    }    
       
}
