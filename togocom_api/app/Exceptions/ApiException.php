<?php

namespace App\Exceptions;

use Exception;


/**
 * Throws Exception for the error with details
 * @member of class ApiException.
 */
class ApiException extends Exception
{
    private array $details = [];

    public function __construct($message, $code = 500)
    {
        parent::__construct($message, $code);
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function hasDetails(): bool
    {
        return !empty($this->details);
    }

    public static function withDetails(array $details, $code = 500): ApiException
    {
        $exception = new ApiException($details['message'] ?? '', $code);
        $exception->details = $details;

        return $exception;
    }
}
