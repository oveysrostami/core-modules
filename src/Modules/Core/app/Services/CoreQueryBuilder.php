<?php
namespace Modules\Core\Services;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class CoreQueryBuilder extends QueryBuilder
{
    protected QueryBuilder $builder;

    public static function for(EloquentBuilder|Relation|string $subject,Request $request = null): static
    {
        return new static($subject, $request ?? request());
    }
    public function search(string $field): static
    {
        $this->builder->allowedFilters([
            AllowedFilter::partial($field)->ignore(null),
        ]);
        return $this;
    }

    public function query(): QueryBuilder
    {
        return $this->builder;
    }
}
