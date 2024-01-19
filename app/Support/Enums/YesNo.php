<?php

namespace App\Support\Enums;

use Illuminate\Support\Collection;

enum YesNo: int
{
    case YES = 1;
    case NO = 0;

    public function labels(): string
    {
        return match ($this) {
            self::YES => 'Yes',
            self::NO  => 'No',
        };
    }

    public static function forSelect(): Collection
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($enum) => [$enum->value => $enum->labels()]);
    }

    public static function inputSelect(): Collection
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($enum) => [$enum->value => ['is_new' => $enum->value, 'value' => $enum->labels()]]);
    }

    public function labelPowergridFilter(): string
    {
        return $this->labels();
    }
}
