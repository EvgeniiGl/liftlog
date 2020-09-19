<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Session;

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
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function render($request, Exception $exception)
    {

        if ($request->wantsJson()) {
            return response([
                'success' => false,
                'message' => $exception->getMessage()
            ], 404);
        }

        if ($exception instanceof AuthorizationException) {
            Session::flash('message', 'Доступ запрещен!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('login');
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|RedirectResponse|Redirector
     */

    protected function unauthenticated($request, AuthenticationException $exception)
    {

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Не авторизован!'], 401);
        }

        Session::flash('message', 'Не авторизован!');
        Session::flash('alert-class', 'alert-danger');
        return redirect('login');

    }
}
