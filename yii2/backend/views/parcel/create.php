<?php

use common\models\Parcel;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Parcel $model
 */

$this->title = Yii::t('app/parcel', 'Добавить посылку');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/parcel', 'Посылки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
