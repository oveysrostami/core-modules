<?php

namespace Modules\User\Classes\DTO;

class UpdateUserData
{
    public function __construct(
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $password = null,
        public ?bool $is_banned = null,
        public ?string $email = null,
        public ?string $mobile_number = null,
    ) {}
}
