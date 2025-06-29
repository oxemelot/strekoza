<?php

use backend\models\search\ParcelSearch;
use common\enums\ParcelStatus;
use common\helpers\DateHelper;
use common\models\Parcel;
use kartik\daterange\DateRangePicker;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var ParcelSearch $searchModel
 */

$this->title = Yii::t('app/parcel', 'Посылки');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/parcel', 'Добавить посылку'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => SerialColumn::class],

            'id',
            'track_number',
            [
                'attribute' => 'status',
                'filter'    => ParcelStatus::map(),
                'value'     => fn ($model) => ParcelStatus::tryFromValue($model->status)?->label() ?? '-',
            ],
            [
                'attribute' => 'created_at',
                'value'     => function ($model) {
                    return DateHelper::toLocal($model->created_at);
                },
                'filter' => DateRangePicker::widget([
                    'model'         => $searchModel,
                    'attribute'     => 'created_at_range',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format'    => 'Y-m-d H:i',
                            'separator' => ' - ',
                        ],
                        'timeZone'            => Yii::$app->timeZone,
                        'timePicker'          => true,
                        'timePickerIncrement' => 5,
                        'autoUpdateInput'     => false,
                    ],
                    'options' => [
                        'class'        => 'form-control',
                        'autocomplete' => 'off',
                    ],
                ]),
            ],
            [
                'attribute' => 'updated_at',
                'value'     => function ($model) {
                    return DateHelper::toLocal($model->updated_at);
                },
                'filter' => DateRangePicker::widget([
                    'model'         => $searchModel,
                    'attribute'     => 'updated_at_range',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format'    => 'Y-m-d H:i',
                            'separator' => ' - ',
                        ],
                        'timeZone'            => Yii::$app->timeZone,
                        'timePicker'          => true,
                        'timePickerIncrement' => 5,
                        'autoUpdateInput'     => false,
                    ],
                    'options' => [
                        'class'        => 'form-control',
                        'autocomplete' => 'off',
                    ],
                ]),
            ],
            [
                'class'      => ActionColumn::class,
                'urlCreator' => function ($action, Parcel $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
