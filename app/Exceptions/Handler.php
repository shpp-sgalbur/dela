<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        Illuminate\Database\QueryException::class
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
        
    $this->renderable(function (Illuminate\Database\QueryException $e, $request) {
        $e->getMessage();
        return response()->view('welcome',['active'=>'Главная']);
    });

    }
    
//    public function render($request, Exception $e)
//    {
//        if ($e instanceof ModelNotFoundException)
//        {
//            // Ваша логика для ненайденной модели...
//            return "file not founf )))";
//        }
//
//        return parent::render($request, $e);
//    }

}
