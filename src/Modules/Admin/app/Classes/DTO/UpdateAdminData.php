<?php

namespace Modules\Admin\Classes\DTO;

class UpdateAdminData
{
    public function __construct(
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $password = null,
        public ?bool $is_banned = null,
    ) {}
}
