<?php

namespace App\Exception;

use \Exception;

class BaseException extends Exception
{

    public function __construct($message = "", array $bizStatus = [], Throwable $previous = null)
    {
        $bizCode = $bizStatus[0];
        $bizMessage = $message ? $message : $bizStatus[1];

        parent::__construct($bizMessage, $bizCode, $previous);
    }

    public function getErrorCode() {
        return $this->getCode();
    }

    public function __destruct()
    {
    }
}