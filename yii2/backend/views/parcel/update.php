<?php

use common\models\Parcel;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Parcel $model
 */

$this->title = Yii::t('app/parcel', 'Редактирование посылки: #{parcelId}', [
    'parcelId' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/parcel', 'Посылки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="parcel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
