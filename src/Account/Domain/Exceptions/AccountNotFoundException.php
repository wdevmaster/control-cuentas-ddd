<?php

namespace Bank\Account\Domain\Exceptions;

use Exception;

class AccountNotFoundException extends Exception
{
    /**
     * AccountNotFoundException constructor.
     *
     * @param string $message El mensaje de error que se mostrará (por defecto 'Account not found').
     * @throws void
     */
    public function __construct(string $message = 'Account not found')
    {
        parent::__construct($message , 404);
    }
}
