<?php

namespace Modules\EventManager\Traits;

use Illuminate\Support\Str;
use Modules\EventManager\Interfaces\ShouldBeLogged;

trait ShouldBeLoggedTrait
{
    public string $uuid;

    public function initEventUUID(): void
    {
        $this->uuid = (string) Str::uuid();
    }
}
