<?php

namespace App\Exceptions;

use Throwable;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
{
    if ($exception instanceof AuthorizationException) {
        return response()->view('Error403', [], 403);
    } elseif ($exception instanceof NotFoundHttpException) {
        return response()->view('Error', [], 404);;
    }

    return parent::render($request, $exception);
}
 
}
