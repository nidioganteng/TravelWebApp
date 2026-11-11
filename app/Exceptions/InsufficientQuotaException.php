<?php

namespace App\Exceptions;

use Exception;

class InsufficientQuotaException extends Exception
{
    public function __construct(int $available)
    {
        parent::__construct("Maaf, sisa tiket tersedia hanya {$available}. Silakan kurangi jumlah tiket.");
    }
}
