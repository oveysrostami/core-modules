<?php

namespace Modules\Notification\Exceptions;

use Exception;

class NotificationDispatchException extends Exception
{
    public function __construct(string $message = "Notification dispatch failed.", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
