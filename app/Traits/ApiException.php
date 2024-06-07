<?php

namespace App\Traits;

use App\Exceptions\EpaoException;

trait ApiException
{
    /**
     * Returna a bad request exception.
     *
     * @param  array|string  $exception
     * @return void
     */
    public function badRequestException(array|string $exception): void
    {
        throw new EpaoException($exception, 400);
    }

    /**
     * Returna a unauthorized request exception.
     *
     * @param  array|string  $exception
     * @return void
     */
    public function unauthorizedRequestException(array|string $exception): void
    {
        throw new EpaoException($exception, 401);
    }

    /**
     * Returna a pre condition failed exception.
     *
     * @param  array|string  $exception
     * @return void
     */
    public function preConditionFailedException(array|string $exception): void
    {
        throw new EpaoException($exception, 412);
    }

    /**
     * Return a not found request exception.
     *
     * @param  array|string  $exception
     * @return void
     */
    public function notFoundRequestException(array|string $exception): void
    {
        throw new EpaoException($exception, 404);
    }

    /**
     * REeturn a server error exception.
     *
     * @param array|string $exception
     * @return void
     */
    public function serverErrorException(array|string $exception): void
    {
        throw new EpaoException($exception, 500);
    }
}
