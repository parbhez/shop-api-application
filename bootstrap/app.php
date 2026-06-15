<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
        
        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                
                $statusCode = 500;
                $message = 'An unexpected error occurred.';
                $errors = null;

                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    $statusCode = $e->status;
                    $message = 'Validation failed.';
                    $errors = $e->errors();
                } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    $statusCode = 401;
                    $message = 'Unauthenticated.';
                } elseif ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException || ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException && $e->getPrevious() instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)) {
                    $statusCode = 404;
                    $actualException = $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? $e : $e->getPrevious();
                    $modelName = strtolower(class_basename($actualException->getModel()));
                    $message = "The requested {$modelName} data could not be found.";
                } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    $statusCode = 404;
                    $message = 'The requested API endpoint was not found.';
                } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
                    $statusCode = 405;
                    $message = 'The HTTP method is not allowed for this endpoint.';
                } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                    $statusCode = $e->getStatusCode();
                    $message = $e->getMessage() ?: 'An HTTP error occurred.';
                } else {
                    $message = $e->getMessage() ?: 'Internal Server Error';
                }

                $response = [
                    'status' => false,
                    'message' => $message,
                    'error_code' => $statusCode,
                ];

                if ($errors !== null) {
                    $response['errors'] = $errors;
                }

                if (config('app.debug') && $statusCode === 500) {
                    $response['debug'] = [
                        'exception' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => collect($e->getTrace())->map(fn ($trace) => \Illuminate\Support\Arr::except($trace, ['args']))->all(),
                    ];
                }

                return response()->json($response, $statusCode);
            }
        });
    })->create();
