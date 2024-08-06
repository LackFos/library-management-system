<?php

use App\Schedules\ResetComicView;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                $message = $e->getMessage();

                $modelNotFoundRegex = '/^No query results for model \[App\\\\Models\\\\(.*)]/';

                if (preg_match($modelNotFoundRegex, $message, $matches)) {
                    $modelName = $matches[1];

                    return response()->json([
                        'success' => false,
                        'message' =>  $modelName . ' not found.',
                    ], 404);
                }
            }
        });
    })
    ->create();


