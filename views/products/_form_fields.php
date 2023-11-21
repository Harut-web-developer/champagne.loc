<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CustomfieldsBlocksTitle;
use app\models\CustomfieldsBlocksInputs;

/** @var yii\web\View $this */
/** @var app\models\Products $model */
/** @var yii\widgets\ActiveForm $form */
$blocks = CustomfieldsBlocksTitle::find()->where(['page'=>'products','block_type'=>1])->orderBy(['order_number'=>SORT_ASC])->all();
$req = true;
if(isset($action__)){
    $req = false;
}
?>


<div class="products-form">
    <div class="card card-primary">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="dinamic-form">
            <input type="hidden" name="page" value="products">
            <div class="default-panel" data-id="10" data-page="products">
                <div class="panel-title">
                    <span class="non-active"><?=$model->DefaultTitle->title?></span>
                    <input type="text" name="newblocks[<?php echo $model->DefaultTitle->id;?>]" value="<?=$model->DefaultTitle->title?>"  class="only-active form-control">
                    <button type="button" class="btn btn-default btn-sm edite-block-title" ><i class='bx bx-edit-alt'></i></button>
                    <button type="button" class="btn btn-default btn-sm edite-block-title-save" ><i class='bx bx-save'></i></button>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 productsCount">
                    <?= $form->field($model, 'count')->input('number',['required' => $req]) ?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 productsPrice">
                    <?= $form->field($model, 'price')->input('number',['required' => $req,]) ?>
                </div>
                <?php $fields = CustomfieldsBlocksInputs::find()->where(['iblock_id'=>10])->all(); ?>
                <?php if(!empty($fields)){ ?>
                    <?php foreach ($fields as $fild => $fild_simple){ ?>
                        <?php echo CustomfieldsBlocksInputs::createElement($fild_simple,$model->id);?>
                    <?php } ?>
                <?php } ?>
                <div class="actions">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm create-block-item dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Create Fild
                        </button>
                        <ul class="dropdown-menu" style="">
                            <li data-type="number">NUMBER <br><span>Lorem ipsum dolor sit amet.</span>
                            </li>
                            <li data-type="varchar">TEXT (255 Simbols) <br><span>Lorem ipsum dolor sit amet.</span></li>
                            <li data-type="list">LIST <br><span>Lorem ipsum dolor sit amet.</span></li>
                            <li data-type="file">FILE <br><span>Lorem ipsum dolor sit amet.</span></li>
                            <li data-type="text">TEXTAREA <br><span>Lorem ipsum dolor sit amet.</span></li>
                            <li data-type="date">DATE <br><span>Lorem ipsum dolor sit amet.</span></li>
                            <li data-type="datetime">DATETIME <br><span>Lorem ipsum dolor sit amet.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php if(!empty($blocks)){ ?>
                <?php foreach ($blocks as $block => $block_val){ ?>
                    <div class="default-panel"  data-id="<?php echo $block_val->id;?>" data-page="products">
                        <div class="panel-title">
                            <span class="non-active"><?=$block_val->title?></span>
                            <input type="text" name="newblocks[<?php echo $block_val->id;?>]" value="<?=$block_val->title?>"  class="only-active form-control">
                            <button type="button" class="btn btn-default btn-sm edite-block-title" ><i class='bx bx-edit-alt'></i></button>
                            <button type="button" class="btn btn-default btn-sm edite-block-title-save" ><i class='bx bx-save'></i></button>
                            <button type="button" class="btn btn-default btn-sm edite-block-trash"><i class="bx bx-trash"></i></button>
                        </div>
                        <?php $fields = CustomfieldsBlocksInputs::find()->where(['iblock_id'=>$block_val->id])->all(); ?>
                        <?php if(!empty($fields)){ ?>
                            <?php foreach ($fields as $fild => $fild_simple){ ?>
                                <?php echo CustomfieldsBlocksInputs::createElement($fild_simple,$model->id,false);?>
                            <?php } ?>
                        <?php } ?>
                        <div class="actions">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm create-block-item dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Create Fild
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li data-type="number">NUMBER <br><span>Lorem ipsum dolor sit amet.</span>
                                    </li>
                                    <li data-type="varchar">TEXT (255 Simbols) <br><span>Lorem ipsum dolor sit amet.</span></li>
                                    <li data-type="list">LIST <br><span>Lorem ipsum dolor sit amet.</span></li>
                                    <li data-type="file">FILE <br><span>Lorem ipsum dolor sit amet.</span></li>
                                    <li data-type="text">TEXTAREA <br><span>Lorem ipsum dolor sit amet.</span></li>
                                    <li data-type="date">DATE <br><span>Lorem ipsum dolor sit amet.</span></li>
                                    <li data-type="datetime">DATETIME <br><span>Lorem ipsum dolor sit amet.</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <button class="btn btn-default btn-sm create-block" type="button">Create Block</button>
        <div class="card-footer">
            <?= Html::submitButton('Save', ['class' => 'btn rounded-pill btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <div class="default-panel createable-panel new-panel" data-page="products">
            <div class="panel-title">
                <span class="non-active">NEW BLOCK</span>
                <input type="text"  value="NEW BLOCK" name="newblocks[]" class="only-active form-control">
                <button type="button" class="btn btn-default btn-sm edite-block-title-new" ><i class='bx bx-edit-alt'></i></button>
                <button type="button" class="btn btn-default btn-sm edite-block-title-save-new-field" ><i class='bx bx-save'></i></button>
                <button type="button" class="btn btn-default btn-sm edite-block-trash-new" onclick="$(this).closest('.new-panel').remove()"><i class="bx bx-trash"></i></button>
            </div>
            <div class="actions">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm create-block-item dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Create Fild
                    </button>
                    <ul class="dropdown-menu" style="">
                        <li data-type="number">NUMBER <br><span>Lorem ipsum dolor sit amet.</span>
                        </li>
                        <li data-type="varchar">TEXT (255 Simbols) <br><span>Lorem ipsum dolor sit amet.</span></li>
                        <li data-type="list">LIST <br><span>Lorem ipsum dolor sit amet.</span></li>
                        <li data-type="file">FILE <br><span>Lorem ipsum dolor sit amet.</span></li>
                        <li data-type="text">TEXTAREA <br><span>Lorem ipsum dolor sit amet.</span></li>
                        <li data-type="date">DATE <br><span>Lorem ipsum dolor sit amet.</span></li>
                        <li data-type="datetime">DATETIME <br><span>Lorem ipsum dolor sit amet.</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>