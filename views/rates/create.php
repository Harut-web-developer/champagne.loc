<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Rates $model */

$this->title = 'Ստեղծել փոխարժեք';
$this->params['breadcrumbs'][] = ['label' => 'Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['sub_page'] = $sub_page;
?>
<div class="rates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
