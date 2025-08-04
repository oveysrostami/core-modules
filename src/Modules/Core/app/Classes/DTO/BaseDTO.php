<?php

namespace Modules\Core\Classes\DTO;

class BaseDTO
{
    public static function fromRequest($request): static
    {
        $data = method_exists($request, 'validated')
            ? $request->validated()
            : $request->all();

        return new static(...$data);
    }
}
