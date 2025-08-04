<?php

namespace Modules\EventManager\Interfaces;

use Str;

interface ShouldBeLogged {
    public function initEventUUID(): void;
}
