<?php

namespace Modules\Acl\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionTreeResourceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $tree = [];
        foreach ($this->collection as $permission) {
            $parts = explode('.', $permission->name);
            $ref = &$tree;

            foreach ($parts as $index => $part) {
                if ($index === count($parts) - 1) {
                    // آخرین بخش
                    $ref[$part] = [
                        'label' => $permission->label ?? null,
                        'name' => $permission->name,
                        'created_at' => $permission->created_at,
                        'updated_at' => $permission->updated_at,
                    ];
                } else {
                    // ادامه درخت
                    $ref[$part] = $ref[$part] ?? [];
                    $ref = &$ref[$part];
                }
            }
        }
        return $tree;
    }
}
