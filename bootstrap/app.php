<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Emailverify;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AcountApproved;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            "email_check" => Emailverify::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'account.approved' => AcountApproved::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        if (request()->is('api/*')) {
            $exceptions->render(function (UnauthorizedException $e, Request $request) {
                return response()->json("Unauthorized action", status: 403);
            });
            $exceptions->render(function (PermissionDoesNotExist $e, Request $request) {
                return response()->json($e->getMessage(), status: 403);
            });
            $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
                return response()->json($e->getMessage(), status: 403);
            });
            $exceptions->render(function (NotFoundHttpException $e, Request $request) {
                return response()->json("record not found", status: 422);
            });
        }
    })->create();
