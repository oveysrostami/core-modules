<?php

namespace Modules\Admin\Classes\DTO;

class CreateAdminData
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $mobile_number,
        public ?string $password,
        public bool $is_banned = false,
    ) {}
}
