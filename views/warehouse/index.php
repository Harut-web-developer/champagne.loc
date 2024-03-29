<?php

use app\models\Users;
use app\models\Warehouse;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\widgets\CustomGridView;
use app\models\CustomfieldsBlocksInputValues;

/** @var yii\web\View $this */
/** @var app\models\WarehouseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Պահեստներ';
$this->params['breadcrumbs'][] = $this->title;
$this->params['sub_page'] = $sub_page;
$this->params['date_tab'] = $date_tab;

$have_access_create = Users::checkPremission(1);
$have_access_update = Users::checkPremission(2);
$have_access_delete = Users::checkPremission(3);
$have_access_custom_field = Users::checkPremission(73);
$action_column = [];
if ($have_access_update && $have_access_delete){
    $action_column[] = [
        'header' => 'Գործողություն',
        'class' => ActionColumn::className(),
        'template' => '{update} {delete}',
        'urlCreator' => function ($action, Warehouse $model, $key, $index, $column) {
            return Url::toRoute([$action, 'id' => $model->id]);
        }
    ];
} else if($have_access_update){
    $action_column[] = [
        'header' => 'Գործողություն',
        'class' => ActionColumn::className(),
        'template' => '{update}',
        'urlCreator' => function ($action, Warehouse $model, $key, $index, $column) {
            return Url::toRoute([$action, 'id' => $model->id]);
        }
    ];
}else if($have_access_delete){
    $action_column[] = [
        'header' => 'Գործողություն',
        'class' => ActionColumn::className(),
        'template' => '{delete}',
        'urlCreator' => function ($action, Warehouse $model, $key, $index, $column) {
            return Url::toRoute([$action, 'id' => $model->id]);
        }
    ];
}
$fields_arr = [];

if(!empty($new_fields)){
    for ($i = 0; $i < count($new_fields); $i++){
        $fields_arr[$i]['attribute'] = $new_fields[$i]['attribute'];
        $fields_arr[$i]['value'] = function ($model,$key, $index, $column) {
            return CustomfieldsBlocksInputValues::getValue($model->id, $column->filterAttribute);
        };
    }
}

?>
<div class="warehouse-index">
    <div class="titleAndPrev">
        <div class="titleAndConfig">
            <i class='bx bxs-log-out iconPrevPage' onclick="window.location = document.referrer"></i>
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <?php if($have_access_custom_field){ ?>
            <h3><?= Html::a('', ['create-fields'], ['class' => 'bx bx-cog right-btn']) ?></h3>
        <?php } ?>
    </div>
    <p>
        <?php if($have_access_create){ ?>
          <?= Html::a('Ստեղծել պահեստ', ['create'], ['class' => 'btn rounded-pill btn-secondary']) ?>
        <?php } ?>
    </p>
    <div class="card pageStyle">
        <?= CustomGridView::widget([
            'summary' => 'Ցուցադրված է <b>{totalCount}</b>-ից <b>{begin}-{end}</b>-ը',
            'summaryOptions' => ['class' => 'summary'],
            'dataProvider' => new ActiveDataProvider([
                'query' => $dataProvider->query->andWhere(['status' => '1']),
//                'pagination' => [
//                    'pageSize' => 20,
//                ],
            ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ...$action_column,
                    'name',
                    'location',
                [
                    'attribute' => 'Տեսակ',
                    'value' => function ($model) {
                        if ($model->type === 'usual') {
                            return 'Սովորական';
                        } else {
                            return 'Վիրտուալ';
                        }
                    }
                ],
                ...$fields_arr,
            ],
        ]); ?>
    </div>
</div>
