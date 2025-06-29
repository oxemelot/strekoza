<?php

use common\enums\ParcelStatus;
use common\helpers\DateHelper;
use common\models\Parcel;
use yii\helpers\Html;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/**
 * @var View $this
 * @var Parcel $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/parcel', 'Посылки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="parcel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'track_number',
            [
                'attribute' => 'status',
                'value'     => fn ($model) => ParcelStatus::tryFromValue($model->status)?->label() ?? '-',
            ],
            [
                'attribute' => 'created_at',
                'value'     => fn (Parcel $parcel) => DateHelper::toLocal($parcel->created_at),
            ],
            [
                'attribute' => 'updated_at',
                'value'     => fn (Parcel $parcel) => DateHelper::toLocal($parcel->updated_at),
            ],
        ],
    ]) ?>

</div>
