<?php

namespace Modules\Wallet\Classes\DTO;

use Modules\User\Models\User;

class CreateUserWalletsData
{
    public function __construct(
        public User $user,
    ) {}
}

