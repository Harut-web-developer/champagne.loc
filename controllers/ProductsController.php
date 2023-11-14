<?php

namespace app\controllers;

use app\models\Nomenclature;
use app\models\Products;
use app\models\ProductsSearch;
use app\models\Warehouse;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Products models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Products();
        if ($this->request->isPost) {
            date_default_timezone_set('Asia/Yerevan');
            $post = $this->request->post();
            $model->warehouse_id = $post['Products']['warehouse_id'];
            $model->nomenclature_id = $post['Products']['nomenclature_id'];
            $model->count = $post['Products']['count'];
            $model->price = $post['Products']['price'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
                return $this->redirect(['index', 'id' => $model->id]);
        } else {
            $model->loadDefaultValues();
        }
        $warehouse = Warehouse::find()->select('id,name')->asArray()->all();
        $warehouse = ArrayHelper::map($warehouse,'id','name');
        $nomenclature = Nomenclature::find()->select('id,name')->asArray()->all();
        $nomenclature = ArrayHelper::map($nomenclature,'id','name');
        return $this->render('create', [
            'model' => $model,
            'warehouse' => $warehouse,
            'nomenclature' => $nomenclature
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            date_default_timezone_set('Asia/Yerevan');
            $post = $this->request->post();
            $model->warehouse_id = $post['Products']['warehouse_id'];
            $model->nomenclature_id = $post['Products']['nomenclature_id'];
            $model->count = $post['Products']['count'];
            $model->price = $post['Products']['price'];
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        $warehouse = Warehouse::find()->select('id,name')->asArray()->all();
        $warehouse = ArrayHelper::map($warehouse,'id','name');
        $nomenclature = Nomenclature::find()->select('id,name')->asArray()->all();
        $nomenclature = ArrayHelper::map($nomenclature,'id','name');
        return $this->render('update', [
            'model' => $model,
            'warehouse' => $warehouse,
            'nomenclature' => $nomenclature
        ]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $products = Products::findOne($id);
        $products->status = '0';
        $products->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
