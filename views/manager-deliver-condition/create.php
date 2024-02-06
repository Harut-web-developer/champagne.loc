<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ManagerDeliverCondition $model */

$this->title = 'Ստեցծել մենեջեր-առաքիչ կապը';
$this->params['breadcrumbs'][] = ['label' => 'Manager Deliver Conditions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['sub_page'] = $sub_page;
$this->params['date_tab'] = $date_tab;
?>
<div class="manager-deliver-condition-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'manager_id' => $manager_id,
        'deliver_id' => $deliver_id,

    ]) ?>

</div>
