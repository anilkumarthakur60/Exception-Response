<?php

namespace Anil\ExceptionResponse\Traits;

use BadMethodCallException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\JsonResponse;
use Illuminate\Session\TokenMismatchException;
use InvalidArgumentException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ApiExceptionResponse
{

    /**
     * @param $request
     * @param $exception
     * @return JsonResponse
     */
    protected function apiException($request, $exception): JsonResponse
    {
        if ($this->isModel($exception)) {
            return $this->ModelResponse($exception);
        }
        if ($this->isMethod($exception)) {
            return $this->MethodResponse($exception);
        }
        if ($this->isHttp($exception)) {
            return $this->HttpResponse($exception);
        }
        if ($this->isBadMethod($exception)) {
            return $this->HttpBadMethodResponse($exception);
        }

        if ($this->isInvalidArgument($exception)) {
            return $this->InvalidArgumentSuppliedResponse($exception);
        }
        if ($this->isTokenMissMatch($exception)) {
            return $this->TokenMissMatchResponse($exception);
        }
        if ($this->isBindingResolutionException($exception)) {
            return $this->BindingResolutionExceptionResponse($exception);
        }

        if ($this->isQueryException($exception)) {
            return $this->QueryExceptionResponse($exception);
        }
        if ($this->isUnauthorized($exception)) {
            return $this->UnauthorizedExceptionResponse($exception);
        }
        if ($this->isPostTooLargeException($exception)) {
            return $this->PostTooLargeExceptionResponse($exception);
        }

        return parent::render($request, $exception);
    }


    protected function isModel($exception): bool
    {
        return $exception instanceof ModelNotFoundException;
    }


    protected function ModelResponse($exception): JsonResponse
    {

        return $this->responses($exception, Response::HTTP_NOT_FOUND);
    }


    protected function isMethod($exception): bool
    {
        return $exception instanceof MethodNotAllowedHttpException;
    }


    protected function MethodResponse($exception): JsonResponse
    {

        return $this->responses($exception, Response::HTTP_METHOD_NOT_ALLOWED);
    }


    protected function isHttp($exception): bool
    {
        return $exception instanceof NotFoundHttpException;
    }


    protected function HttpResponse($exception): JsonResponse
    {
        return $this->responses($exception, Response::HTTP_NOT_FOUND);
    }


    protected function isBadMethod($exception): bool
    {
        return $exception instanceof BadMethodCallException;
    }


    protected function HttpBadMethodResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }


    protected function isInvalidArgument($exception): bool
    {
        return $exception instanceof InvalidArgumentException;
    }


    protected function InvalidArgumentSuppliedResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }


    protected function isTokenMissMatch($exception): bool
    {
        return $exception instanceof TokenMismatchException;
    }


    protected function TokenMissMatchResponse($exception): JsonResponse
    {
        return $this->responses($exception, Response::HTTP_UNAUTHORIZED);
    }


    protected function isBindingResolutionException($exception): bool
    {
        return $exception instanceof BindingResolutionException;
    }


    protected function BindingResolutionExceptionResponse($exception): JsonResponse
    {
        return $this->responses($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    protected function isQueryException($exception): bool
    {
        return $exception instanceof QueryException;
    }


    protected function QueryExceptionResponse($exception): JsonResponse
    {
        return $this->responses($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    protected function isUnauthorized($exception): bool
    {
        return $exception instanceof UnauthorizedException;
    }


    protected function UnauthorizedExceptionResponse($exception): JsonResponse
    {
        return $this->responses($exception, Response::HTTP_FORBIDDEN);
    }


    protected function isPostTooLargeException($exception): bool
    {
        return $exception instanceof PostTooLargeException;
    }


    protected function PostTooLargeExceptionResponse($exception): JsonResponse
    {
        return $this->responses($exception, Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
    }


    private function responses($exception, $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'message' => $exception->getMessage(),
//            'code' => $exception->getCode(),
            'code' => $exception->getStatusCode(),

            //            'file' => $exception->getFile(),
            //            'line' => $exception->getLine(),
        ], $code);
    }

}