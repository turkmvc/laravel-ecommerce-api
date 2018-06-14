<?php

namespace App\Exceptions;
use \Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ExceptionTrait
{
    public function apiException($request, $e)
    {
        /**
         * Handle ModelNotFoundException and returns response in json data
         */
        if($this->isModel($e)) {
            return $this->modelResponse($e);
        }

        /**
         * Handle NotFoundHttpException and returns response in json data
         */
        if($this->isHttp($e))
        {
            return $this->httpResponse($e);
        }

        /**
         * If nothing above happens, it returns the normal exception
         */
        return parent::render($request, $exception);
    }

    // Check if is a model exception
    public function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    // Check if is an http exception
    public function isHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }

    // returns a ModelNotFoundException response
    public function modelResponse($e)
    {
        return response()->json([
            'errors' => 'Product model not found!'
        ], Response::HTTP_NOT_FOUND);
    }

    // returns a HttpNotFoundException response
    public function httpResponse($e)
    {
        return response()->json([
            'errors' => 'Incorrect route'
        ], Response::HTTP_NOT_FOUND);
    }
}