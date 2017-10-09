<?php

namespace backend\controllers;

use backend\models\ResetpswdForm;
use backend\models\SignupForm;
use common\models\Adminuser;
use common\models\AdminuserSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AdminuserController implements the CRUD actions for Adminuser model.
 */
class AdminuserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Adminuser models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new AdminuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adminuser model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Adminuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $user = $model->signup()) {
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('create', [
                'model' => $model,
            ]);
    }
    
    /**
     * reset adminuser password.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionResetpwd($id)
    {
        $model = new ResetpswdForm();

        if ($model->load(Yii::$app->request->post()) && $model->resetPswd($id)) {
            return $this->redirect(['index']);
        }

        return $this->render('resetpwd', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Adminuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing Adminuser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Adminuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @return Adminuser the loaded model
     */
    protected function findModel($id)
    {
        if (($model = Adminuser::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
