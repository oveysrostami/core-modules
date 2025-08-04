<?php

namespace Modules\Notification\Classes\DTO;

use Illuminate\Database\Eloquent\Model;

class InternalNotificationDTO
{
    public function __construct(
        public Model $user,
        public string $template,
        public ?array $variables = [],
        public ?array $meta = [],
    ) {}
}
