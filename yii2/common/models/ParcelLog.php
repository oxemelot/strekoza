<?php

declare(strict_types=1);

namespace common\models;

use common\models\queries\ParcelLogQuery;
use common\models\queries\ParcelQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%parcel_log}}".
 *
 * Attributes:
 * @property int $id ID
 * @property int $parcel_id ID посылки
 * @property int $action Действие
 * @property string $old Старые аттрибуты
 * @property string $new Новые аттрибуты
 * @property string $created_at Дата создания
 *
 * Relations:
 * @property Parcel $parcel
 */
class ParcelLog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%parcel_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['parcel_id', 'action', 'old', 'new'], 'required'],
            [['parcel_id', 'action'], 'default', 'value' => null],
            [['parcel_id', 'action'], 'integer'],
            [['old', 'new'], 'safe'],
            [['parcel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parcel::class, 'targetAttribute' => ['parcel_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'         => 'ID',
            'parcel_id'  => 'ID посылки',
            'action'     => 'Действие',
            'old'        => 'Старые аттрибуты',
            'new'        => 'Новые аттрибуты',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Gets query for [[Parcel]].
     */
    public function getParcel(): ActiveQuery|ParcelQuery
    {
        return $this->hasOne(Parcel::class, ['id' => 'parcel_id'])->inverseOf('parcelLogs');
    }

    /**
     * {@inheritdoc}
     *
     * @return ParcelLogQuery the active query used by this AR class.
     */
    public static function find(): ParcelLogQuery
    {
        return new ParcelLogQuery(get_called_class());
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
