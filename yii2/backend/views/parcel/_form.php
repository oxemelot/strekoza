<?php

use common\enums\ParcelStatus;
use common\models\Parcel;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var Parcel $model
 */

?>

<div class="parcel-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'options' => ['class' => 'form-group mb-3'],
        ],
    ]); ?>

    <?= $form->field($model, 'track_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        ParcelStatus::map(),
        ['prompt' => Yii::t('app', 'Выберите статус...')]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
