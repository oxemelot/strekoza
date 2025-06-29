<?php

use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4"><?= Html::encode(Yii::$app->name) ?></h1>
        </div>
    </div>

    <div class="body-content">
    </div>

</div>
