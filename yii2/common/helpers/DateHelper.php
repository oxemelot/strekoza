<?php

declare(strict_types=1);

namespace common\helpers;

use DateTime;
use DateTimeZone;
use Throwable;
use Yii;

class DateHelper
{
    /**
     * Преобразует дату (строку или DateTime) из UTC (или другой зоны) в локальную (Yii::$app->timeZone).
     *
     * @param string|DateTime|null $date Входная дата
     * @param string $format Формат вывода, например 'Y-m-d H:i:s'
     * @param string|null $fromTimezone Входная таймзона, по умолчанию UTC (если $date — строка)
     */
    public static function toLocal(string|DateTime|null $date, string $format = 'Y-m-d H:i:s', ?string $fromTimezone = null): ?string
    {
        if ($date === null) {
            return null;
        }

        try {
            if ($date instanceof DateTime) {
                $dt = clone $date;
            } else {
                $fromTz = new DateTimeZone($fromTimezone ?? 'UTC');
                $dt = new DateTime($date, $fromTz);
            }

            $dt->setTimezone(new DateTimeZone(Yii::$app->timeZone));

            return $dt->format($format);
        } catch (Throwable $e) {
            Yii::error('Ошибка в toLocal(): ' . $e->getMessage(), __METHOD__);
            return null;
        }
    }

    /**
     * Преобразует дату (строку или DateTime) из локальной временной зоны (Yii::$app->timeZone)
     * в UTC (или другую зону, если указана).
     *
     * @param string|DateTime|null $date Входная дата
     * @param string $format Формат вывода, например 'Y-m-d H:i:s'
     * @param string|null $toTimezone Выходная таймзона, по умолчанию UTC
     */
    public static function toUtc(string|DateTime|null $date, string $format = 'Y-m-d H:i:s', ?string $toTimezone = null): ?string
    {
        if ($date === null) {
            return null;
        }

        try {
            if ($date instanceof DateTime) {
                $dt = clone $date;
            } else {
                $localTz = new DateTimeZone(Yii::$app->timeZone);
                $dt = new DateTime($date, $localTz);
            }

            $dt->setTimezone(new DateTimeZone($toTimezone ?? 'UTC'));

            return $dt->format($format);
        } catch (Throwable $e) {
            Yii::error('Ошибка в toUtc(): ' . $e->getMessage(), __METHOD__);
            return null;
        }
    }
}
