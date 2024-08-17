<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $message;
    protected $statusCode;

    public function __construct($message, $statusCode = 400)
    {
        parent::__construct($message, $statusCode);
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function render()
    {
        return response()->json([
            'message' => $this->message,
        ], $this->statusCode);
    }
}
