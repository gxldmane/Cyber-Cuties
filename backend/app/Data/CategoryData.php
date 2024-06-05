<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\CamelCaseMapper;

#[MapName(CamelCaseMapper::class)]
class CategoryData extends Data
{
    public function __construct(
        public string $name,
        public string $cover_path
    )
    {}
}
