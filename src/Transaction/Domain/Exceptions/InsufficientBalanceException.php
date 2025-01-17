<?php

namespace Bank\Transaction\Domain\Exceptions;

use Exception;

class InsufficientBalanceException extends Exception
{
    /**
     * Constructor de la excepción InsufficientBalanceException.
     *
     * @param string $message El mensaje de la excepción.
     * @param int $code El código de la excepción.
     * @param Exception|null $previous La excepción previa.
     */
    public function __construct(string $message = "Insufficient balance to make the withdrawal") {
        parent::__construct($message, 400);
    }
}
