<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CustomfieldsBlocksTitle;
use app\models\CustomfieldsBlocksInputs;

/** @var yii\web\View $this */
/** @var app\models\Documents $model */
/** @var yii\widgets\ActiveForm $form */

$blocks = CustomfieldsBlocksTitle::find()->where(['page'=>'documents','block_type'=>1])->orderBy(['order_number'=>SORT_ASC])->all();
$req = true;
if(isset($action__)){
    $req = false;
}
$type = $model->document_type;
$session = Yii::$app->session;

?>
<?php if ($model->id){
    if ($model->document_type === '1'){
        $value = 'Մուտք';
    }elseif ($model->document_type === '2'){
        $value = 'Ելք';
    }elseif ($model->document_type === '3'){
        $value = 'Տեղափոխություն';
    }elseif ($model->document_type === '4'){
        $value = 'Խոտան';
    }elseif ($model->document_type === '6'){
        $value = 'Վերադարձրած';
    }elseif ($model->document_type === '7'){
        $value = 'Մերժված';
    }elseif ($model->document_type === '8'){
        $value = 'Մուտք(վերադարցրած)';
    }
    ?>
    <div class="documents-form">
        <div class="card card-primary">
            <?php $form = ActiveForm::begin(); ?>
            <div class="default-panel">
                <div class="panel-title premission">
                    <span class="non-active">Փաստաթուղթ</span>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?= $form->field($model, 'warehouse_id')->dropDownList($warehouse) ?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?= $form->field($model, 'document_type')->textInput([ 'value' => $value, 'readonly' => true ]) ?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName toWarehouse">
                    <?= $form->field($model, 'to_warehouse')->dropDownList($to_warehouse) ?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?php
                    if($session['role_id'] == 1){?>
                       <?= $form->field($model, 'user_id')->dropDownList($users) ?>
                   <?php }elseif ($session['role_id'] == 4){?>
                        <?= $form->field($model, 'user_id')->hiddenInput(['value' => $session['user_id']])->label(false) ?>
                    <?php } ?>
                </div>

                <label class="rateLabel" for="rate">Փոխարժեք</label>
                <div id="rate" class="form-group col-md-12 col-lg-12 col-sm-12 rateDocument">
                    <div class="rateType">
                        <?= $form->field($model, 'rate_id')->dropDownList($rates)->label(false) ?>
                    </div>
                    <div class="rateValue">
                        <?= $form->field($model, 'rate_value')->input('number')->label(false) ?>
                    </div>
                </div>

                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <label for="aah">ԱԱՀ</label>
                    <select class="form-control" name="aah" id="aah">
                        <option value="true" <?php if(isset($aah['AAH']) && $aah['AAH'] === 'true'){ echo  'selected';} ?>>20%</option>
                        <option value="false" <?php if(isset($aah['AAH']) && $aah['AAH'] === 'false'){ echo  'selected';} ?>>0%</option>
                    </select>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?php
                    if ($type == '7'){?>
                        <?= $form->field($model, 'comment')->textArea(['maxlength' => true, 'disabled' => true]) ?>
                    <?php }elseif($type == '6'){?>
                        <?= $form->field($model, 'comment')->textArea(['maxlength' => true, 'disabled' => true]) ?>
                    <?php }else{?>
                        <?= $form->field($model, 'comment')->textArea(['maxlength' => true]) ?>
                    <?php }?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?= $form->field($model, 'date')->input('datetime-local') ?>
                </div>
                <?php $fields = CustomfieldsBlocksInputs::find()->where(['iblock_id'=>41])->all(); ?>
                <?php if(!empty($fields)){ ?>
                    <?php foreach ($fields as $fild => $fild_simple){ ?>
                        <?php echo CustomfieldsBlocksInputs::createElement($fild_simple,$model->id);?>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php if(!empty($blocks)){ ?>
                <?php foreach ($blocks as $block => $block_val){ ?>
                    <div class="default-panel"  data-id="<?php echo $block_val->id;?>" data-page="clients">
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
                                    Ստեղծել դաշտ
                                </button>
                                <ul class="dropdown-menu custom_field_menu" style="">
                                    <li data-type="number">NUMBER <br><span>Թվային արժեք ավելացնելու դաշտ:</span></li>
                                    <li data-type="varchar">TEXT (255 Simbols) <br><span>Տեքստ ավելացնելու դաշտ:</span></li>
                                    <li data-type="list">LIST <br><span>Ցուցակներ լրացնելու դաշտ:</span></li>
                                    <li data-type="file">FILE <br><span>Նկար ավելացնելու դաշտ:</span></li>
                                    <li data-type="text">TEXTAREA <br><span>Մեշ ծավալով տեքստ ավելացնելու դաշտ:</span></li>
                                    <li data-type="date">DATE <br><span>Ամսաթիվ ավելացնելու դաշտ:</span></li>
                                    <li data-type="datetime">DATETIME <br><span>Ժամ և ամսաթիվ ավելացնելու դաշտ:</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="default-panel">
                <div class="panel-title premission">
                    <span class="non-active">Ապրանքացուցակ</span>
                </div>
                <div class="card">
                    <div class="table-responsive text-nowrap">
                        <table class="table documentsAddingTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Անուն</th>
                                <th>Քանակ</th>
                                <th>Գինը առանց ԱԱՀ-ի</th>
                                <th>Գինը ներառյալ ԱԱՀ-ն</th>
                                <?php
                                if ($type == '1' || $type == '2' || $type == '3' || $type == '4'){?>
                                    <th>Գործողություն</th>
                                <?php }?>
                            </tr>
                            </thead>
                            <tbody class="old_tbody">
                            <?php
                            $itemsArray = [];
                            foreach ($document_items as $keys => $document_item){
                                $itemsArray[] = $document_item['nom_id'];
                                ?>
                                <tr class="oldTr" id="tr_<?=$document_item['nom_id']?>">
                                    <td>
                                        <span><?=$keys + 1?></span>
                                        <input class="docItemsId" type="hidden" name="document_items[]" value="<?=$document_item['id']?>">
                                        <input class="itemsId" type="hidden" name="items[]" value="<?=$document_item['nom_id']?>">
                                    </td>
                                    <td class="name"><?=$document_item['name']?></td>
                                    <?php
                                    if ($model->document_type == '7'){?>
                                        <td class="count"><input type="number" name="count_[]" disabled value="<?=$document_item['count']?>" class="form-control countDocuments" min="1" step="any"></td>
                                        <td class="price"><input type="number" name="price[]" disabled value="<?=$document_item['price']?>" class="form-control PriceDocuments"></td>
                                    <?php }else{?>
                                        <td class="count"><input type="number" name="count_[]" value="<?=$document_item['count']?>" class="form-control countDocuments" min="1" step="1"></td>
                                        <td class="price"><input type="number" name="price[]" value="<?=$document_item['price']?>" class="form-control PriceDocuments"></td>
                                    <?php }?>

                                    <td class="pricewithaah">
                                        <span><?=number_format($document_item['price_with_aah'],2,'.', '')?></span>
                                        <input type="hidden" name="pricewithaah[]" value="<?=number_format($document_item['price_with_aah'],2,'.', '')?>" class="form-control PriceWithaah">
                                    </td>
                                    <?php
                                    if ($type == '1' || $type == '2' || $type == '3' || $type == '4'){?>
                                        <td><button  type="button" class="btn rounded-pill btn-outline-danger deleteDocumentItems">Ջնջել</button></td>
                                    <?php }?>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Button trigger modal -->
                <?php
                if ($type == '1' || $type == '2' || $type == '3' || $type == '4'){?>
                    <button type="button" class="btn rounded-pill btn-secondary addDocuments addDocuments_get_type_val_update" data-bs-toggle="modal" data-bs-target="#documentsModal">Ավելացնել ապրանք</button>
                <?php }?>
                <!-- Modal -->
                <div class="modal fade" id="documentsModal" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel3">Ապրանքացուցակ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input class="form-control col-md-3 mb-3 searchForDocumentUpdate" type="search" placeholder="Որոնել...">
                                <div id="ajax_content">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn rounded-pill btn-secondary updateDocuments" data-bs-dismiss="modal">Ավելացնել ցուցակում</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <?php
                if ($type == '1' || $type == '2' || $type == '3' || $type == '4'){?>
                    <?= Html::submitButton('Պահպանել', ['class' => 'btn rounded-pill  btn-secondary']) ?>
                <?php }?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php
}else{
    ?>
    <div class="documents-form">
        <div class="card card-primary">
            <?php $form = ActiveForm::begin(); ?>
            <div class="default-panel">
                <div class="panel-title premission">
                    <span class="non-active">Փաստաթուղթ</span>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?= $form->field($model, 'warehouse_id')->dropDownList(['' => 'Ընտրել պահեստը'] + $warehouse) ?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?= $form->field($model, 'document_type')->dropDownList([ '1' => 'Մուտք', '2' => 'Ելք','3' => 'Տեղափոխություն','4' => 'Խոտան', ]) ?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName toWarehouse">
                    <?= $form->field($model, 'to_warehouse')->dropDownList(['' => 'Ընտրել պահեստը'] + $to_warehouse) ?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?php
                    if($session['role_id'] == 1){?>
                        <?= $form->field($model, 'user_id')->dropDownList($users) ?>
                    <?php }elseif ($session['role_id'] == 4){?>
                        <?= $form->field($model, 'user_id')->hiddenInput(['value' => $session['user_id']])->label(false) ?>
                    <?php } ?>
                </div>

                <label class="rateLabel" for="rate">Փոխարժեք</label>
                <div id="rate" class="form-group col-md-12 col-lg-12 col-sm-12 rateDocument">
                    <div class="rateType">
                        <?= $form->field($model, 'rate_id')->dropDownList($rates)->label(false) ?>
                    </div>
                    <div class="rateValue">
                        <?= $form->field($model, 'rate_value')->input('number', ['required' => true,'value' => 1, 'readonly' => true])->label(false) ?>
                    </div>

                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <label for="aah">ԱԱՀ</label>
                    <select class="form-control" name="aah" id="aah">
                        <option value="true">20%</option>
                        <option value="false">0%</option>
                    </select>
                </div>

                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?= $form->field($model, 'comment')->textArea(['maxlength' => true]) ?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 ordersName">
                    <?= $form->field($model, 'date')->input('datetime-local') ?>
                </div>
                <?php $fields = CustomfieldsBlocksInputs::find()->where(['iblock_id'=>41])->all(); ?>
                <?php if(!empty($fields)){ ?>
                    <?php foreach ($fields as $fild => $fild_simple){ ?>
                        <?php echo CustomfieldsBlocksInputs::createElement($fild_simple,$model->id);?>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php if(!empty($blocks)){ ?>
                <?php foreach ($blocks as $block => $block_val){ ?>
                    <div class="default-panel"  data-id="<?php echo $block_val->id;?>" data-page="clients">
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
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm create-block-item dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ստեղծել դաշտ
                                    </button>
                                    <ul class="dropdown-menu custom_field_menu" style="">
                                        <li data-type="number">NUMBER <br><span>Թվային արժեք ավելացնելու դաշտ:</span></li>
                                        <li data-type="varchar">TEXT (255 Simbols) <br><span>Տեքստ ավելացնելու դաշտ:</span></li>
                                        <li data-type="list">LIST <br><span>Ցուցակներ լրացնելու դաշտ:</span></li>
                                        <li data-type="file">FILE <br><span>Նկար ավելացնելու դաշտ:</span></li>
                                        <li data-type="text">TEXTAREA <br><span>Մեշ ծավալով տեքստ ավելացնելու դաշտ:</span></li>
                                        <li data-type="date">DATE <br><span>Ամսաթիվ ավելացնելու դաշտ:</span></li>
                                        <li data-type="datetime">DATETIME <br><span>Ժամ և ամսաթիվ ավելացնելու դաշտ:</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="default-panel">
                <div class="panel-title premission">
                    <span class="non-active">Ապրանքացուցակ</span>
                </div>
                <div class="card">
                    <div class="table-responsive text-nowrap">
                        <table class="table documentsAddingTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Անուն</th>
                                <th>Քանակ</th>
                                <th>Գինը առանց ԱԱՀ-ի</th>
                                <th>Գինը ներառյալ ԱԱՀ-ն</th>
                                <th>Գործողություն</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Button trigger modal -->
                <!--disabled-->
                <button type="button" class="btn rounded-pill btn-secondary addDocuments addDocuments_get_type_val" data-bs-toggle="modal" data-bs-target="#documentsModal" disabled>Ավելացնել ապրանք</button>
                <!-- Modal -->
                <div class="modal fade" id="documentsModal" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel3">Ապրանքացուցակ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input class="form-control col-md-3 mb-3 searchForDocument" type="search" placeholder="Որոնել...">
                                <div id="ajax_content">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn rounded-pill btn-secondary createDocuments" data-bs-dismiss="modal">Ավելացնել ցուցակում</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <?= Html::submitButton('Պահպանել', ['class' => 'btn rounded-pill  btn-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php
}
?>


<?php
$this->registerJsFile(
    '@web/js/documents.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>

<style>
    /* Vendor prefixes for cross-browser support */
    input[type="search"]::-webkit-search-cancel-button,
    input[type="search"]::-webkit-search-clear-button {
        -webkit-appearance: none;
        appearance: none;
        display: none;
    }
</style>