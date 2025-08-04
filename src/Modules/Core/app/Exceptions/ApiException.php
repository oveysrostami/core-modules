<?php

namespace Modules\Core\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function __construct(
        public string $errorCode,
        public array $replace = [],
        public int $status = 422,
        public string $translationNamespace = 'core'
    ) {
        parent::__construct($errorCode);
    }
}
