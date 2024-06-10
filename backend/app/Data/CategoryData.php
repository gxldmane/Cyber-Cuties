<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\LoadRelation;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\CamelCaseMapper;

#[MapName(CamelCaseMapper::class)]
class CategoryData extends Data
{

    public function __construct(
        public string $id,
        public string $name,
        public string $coverPath,
        /** @var array<RankData>  */
        public ?array $ranks,
    )
    {
    }
    public function defaultWrap(): string
    {
        return 'data';
    }
}
