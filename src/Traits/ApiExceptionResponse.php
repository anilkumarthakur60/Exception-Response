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
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ApiExceptionResponse
{
    protected function apiException($request, $exception): JsonResponse
    {
        if ($this->isModel($exception)) {
            return $this->modelResponse($exception);
        }
        if ($this->isMethod($exception)) {
            return $this->methodResponse($exception);
        }
        if ($this->isHttp($exception)) {
            return $this->httpResponse($exception);
        }
        if ($this->isBadMethod($exception)) {
            return $this->httpBadMethodResponse($exception);
        }

        if ($this->isInvalidArgument($exception)) {
            return $this->invalidArgumentSuppliedResponse($exception);
        }
        if ($this->isTokenMissMatch($exception)) {
            return $this->tokenMissMatchResponse($exception);
        }
        if ($this->isBindingResolutionException($exception)) {
            return $this->bindingResolutionExceptionResponse($exception);
        }

        if ($this->isQueryException($exception)) {
            return $this->queryExceptionResponse($exception);
        }
        if ($this->isUnauthorized($exception)) {
            return $this->unauthorizedExceptionResponse($exception);
        }
        if ($this->isPostTooLargeException($exception)) {
            return $this->postTooLargeExceptionResponse($exception);
        }

        return parent::render($request, $exception);
    }

    protected function isModel($exception): bool
    {
        return $exception instanceof ModelNotFoundException;
    }

    protected function modelResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    protected function isMethod($exception): bool
    {
        return $exception instanceof MethodNotAllowedHttpException;
    }

    protected function methodResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    protected function isHttp($exception): bool
    {
        return $exception instanceof NotFoundHttpException;
    }

    protected function httpResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    protected function isBadMethod($exception): bool
    {
        return $exception instanceof BadMethodCallException;
    }

    protected function httpBadMethodResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    protected function isInvalidArgument($exception): bool
    {
        return $exception instanceof InvalidArgumentException;
    }

    protected function invalidArgumentSuppliedResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    protected function isTokenMissMatch($exception): bool
    {
        return $exception instanceof TokenMismatchException;
    }

    protected function tokenMissMatchResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    protected function isBindingResolutionException($exception): bool
    {
        return $exception instanceof BindingResolutionException;
    }

    protected function bindingResolutionExceptionResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    protected function isQueryException($exception): bool
    {
        return $exception instanceof QueryException;
    }

    protected function queryExceptionResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    protected function isUnauthorized($exception): bool
    {
        return $exception instanceof UnauthorizedException;
    }

    protected function unauthorizedExceptionResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    protected function isPostTooLargeException($exception): bool
    {
        return $exception instanceof PostTooLargeException;
    }

    protected function postTooLargeExceptionResponse($exception): JsonResponse
    {
        return $this->responses($exception);
    }

    private function responses($exception): JsonResponse
    {
        return response()->json([
            'message' => $exception->getMessage(),
        ], $exception->getStatusCode());
    }
}
