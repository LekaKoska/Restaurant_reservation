<?php
    namespace App\Facades;

use App\Services\ResponseServices;
use Illuminate\Support\Facades\Facade;

class ResponseFacade extends Facade
{
   public static function getFacadeAccessor()
   {
       return ResponseServices::class;
   }
}
