<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Illuminate\Validation\ValidationException $e, Request $request) {
            return response()->json('error: ' . $e->getMessage(), 422);
        });
        $exceptions->render(function (Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {
            return response()->json('error: ' . $e->getMessage(), 404);
        });
        $exceptions->render(function (Illuminate\Database\QueryException $e, Request $request) {
            return response()->json('error: ' . $e->getMessage(), 400);
        });
        $exceptions->render(function (Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e, Request $request) {
            return response()->json('error: ' . $e->getMessage(), 404);
        });
    })->create();
