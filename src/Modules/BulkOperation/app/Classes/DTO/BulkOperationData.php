<?php

namespace Modules\BulkOperation\Classes\DTO;

use Modules\Core\Classes\DTO\BaseDTO;

class BulkOperationData extends BaseDTO
{
    public function __construct(
        public int $file_id,
        public string $type,
    ) {}
}
