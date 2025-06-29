<?php

declare(strict_types=1);

namespace common\models;

use common\enums\ParcelStatus;
use common\models\queries\ParcelLogQuery;
use common\models\queries\ParcelQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%parcel}}".
 *
 * Attributes:
 * @property int $id ID
 * @property string $track_number Номер трека
 * @property int $status Статус
 * @property string $created_at Дата создания
 * @property string|null $updated_at Дата обновления
 *
 * Relations:
 * @property ParcelLog[] $parcelLogs Логи
 */
class Parcel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%parcel}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['track_number', 'status'], 'required'],
            [['track_number'], 'string', 'max' => 255],
            [['track_number'], 'unique'],
            ['status', 'in', 'range' => array_column(ParcelStatus::cases(), 'value')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'           => Yii::t('app/attributes', 'ID'),
            'track_number' => Yii::t('app/attributes', 'Номер трека'),
            'status'       => Yii::t('app/attributes', 'Статус'),
            'created_at'   => Yii::t('app/attributes', 'Дата создания'),
            'updated_at'   => Yii::t('app/attributes', 'Дата обновления'),
        ];
    }

    /**
     * Gets query for [[ParcelLogs]].
     */
    public function getParcelLogs(): ActiveQuery|ParcelLogQuery
    {
        return $this->hasMany(ParcelLog::class, ['parcel_id' => 'id'])->inverseOf('parcel');
    }

    /**
     * {@inheritdoc}
     *
     * @return ParcelQuery the active query used by this AR class.
     */
    public static function find(): ParcelQuery
    {
        return new ParcelQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}
