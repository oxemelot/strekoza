<?php

declare(strict_types=1);

namespace common\enums;

interface LabelledEnum
{
    public function label(): string;

    /**
     * @return array<int|string, string> // value => label
     */
    public static function map(): array;
}
