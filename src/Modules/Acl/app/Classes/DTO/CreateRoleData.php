<?php

namespace Modules\Acl\Classes\DTO;

use Modules\Core\Classes\DTO\BaseDTO;

class CreateRoleData extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $label,
        public string $guard_name,
        public array $permissions = [],
    ) {}
}
