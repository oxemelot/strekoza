<?php

declare(strict_types=1);

namespace common\enums;

use Yii;

enum ParcelStatus: int implements LabelledEnum
{
    case New = 0;
    case InProgress = 1;
    case Completed = 2;
    case Failed = 3;
    case Canceled = 4;

    public function label(): string
    {
        return match ($this) {
            self::New        => Yii::t('app/parcel/status', 'Новая'),
            self::InProgress => Yii::t('app/parcel/status', 'В пути'),
            self::Completed  => Yii::t('app/parcel/status', 'Доставлена'),
            self::Failed     => Yii::t('app/parcel/status', 'Ошибка'),
            self::Canceled   => Yii::t('app/parcel/status', 'Отменена'),
        };
    }

    public static function map(): array
    {
        return array_combine(
            array_map(fn (self $case) => $case->value, self::cases()),
            array_map(fn (self $case) => $case->label(), self::cases())
        );
    }

    public static function tryFromValue(int|string|null $value): ?self
    {
        return is_null($value) ? null : self::tryFrom((int) $value);
    }
}
