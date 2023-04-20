<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\Response;
use League\OAuth2\Server\Exception\OAuthServerException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        OAuthServerException::class,
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

   public function render($request, Throwable $e)
    {
        $response = [
            'success' => false
        ];
        $response['status']   = null;

        if ($e instanceof HttpResponseException) {
            $response['status']   = Response::HTTP_INTERNAL_SERVER_ERROR;
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $response['status'] = Response::HTTP_METHOD_NOT_ALLOWED;
        } elseif ($e instanceof NotFoundHttpException) {
            $response['status'] = Response::HTTP_NOT_FOUND;
        } elseif ($e instanceof AuthorizationException) {
            $response['status'] = Response::HTTP_FORBIDDEN;
            $e      = new AuthorizationException('HTTP_FORBIDDEN', $response['status']);
        } elseif ($e instanceof ValidationException && $e->getResponse()) {
            $response['status']   = Response::HTTP_BAD_REQUEST;
            $e        = new ValidationException('HTTP_BAD_REQUEST', $response['status'], $e);
        } elseif ($e instanceof ValidationException) {
            $response['status']   = 422;
            $response['errors'] = $e->validator->errors();
        } elseif ($e instanceof ModelNotFoundException) {
          $response['status'] = 404;
        } elseif ($e instanceof UnableToExecuteRequestException) {
            $response['status'] = $e->getCode();
        } elseif ($e instanceof FatalThrowableError) {
            $response['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        } elseif ($e instanceof OAuthServerException && $e->getCode() == 9) {
            $response['status']   = 'Kill reporting if this is an "access denied"';
        } elseif ($e) {
            $response['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response['unhandled'] = 'exception-lumen-ksoft';
        }

        if ($response['status']) {
            $response['message'] = $e->getMessage();
            $response['error_code'] = $e->getCode() ?? '';
            // $response['exception'] = $e->getTraceAsString() ?? '';
            if (app()->environment() == 'local'){
                $response['file'] = $e->getFile() ?? '';
                $response['line'] = $e->getLine() ?? '';
            }

            // $this->sendErrorMessage($request->path(), $response);

            return response()->json($response, $response['status']);
        } else {
            return parent::render($request, $e);
        }
     
        return parent::render($request, $e);
    }
}
