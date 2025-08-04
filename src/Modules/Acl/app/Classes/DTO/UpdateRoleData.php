<?php

namespace Modules\Acl\Classes\DTO;

use Modules\Core\Classes\DTO\BaseDTO;

class UpdateRoleData extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $label,
        public array  $permissions = [])
    {
    }
}
