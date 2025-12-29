<?php

namespace App\Exceptions;

use Exception;

class ConflitoHorarioException extends Exception
{
    protected $message = 'A sala já está reservada neste horário.';

    public function __construct(string $message = null, int $code = 409, Exception $previous = null)
    {
        parent::__construct($message ?? $this->message, $code, $previous);
    }
}

