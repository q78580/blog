<?php

namespace backend\controllers;

use backend\models\ResetPasswordForm;
use common\models\AuthAssignment;
use common\models\AuthItem;
use Yii;
use common\models\AdminUser;
use backend\models\SignupForm;
use common\models\AdminUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminUserController implements the CRUD actions for AdminUser model.
 */
class AdminUserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AdminUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdminUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
//
            if($user)
            {
                return $this->redirect(['view', 'id' => $user->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdminUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdminUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionReset($id){
        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post())) {

            if($model->resetPassword($id))
            {
                return $this->redirect(['index']);
            }

        } else {
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }
    }
    public function actionPrivilege($id){
        $auth_item = AuthItem::find()->select(['name','description'])->where(['type'=>1])->orderBy('description')->all();
        foreach($auth_item as $value){
            $allPrivilegesArray[$value->name] = $value->description;
        }
        $authAssignments = AuthAssignment::find()->select(['item_name'])->where(['user_id'=>$id])->all();
        $authAssignmentsArray = [];
        foreach($authAssignments as $v){
            array_push($authAssignmentsArray,$v->item_name);
        }
        $model = $this->findModel($id);
        if (isset($_POST['newPri'])) {
            $post = $_POST['newPri'];
            $model->privilege($post);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('privilege',['id'=>$id,'allPrivileges'=>$allPrivilegesArray,'authAssignments'=>$authAssignmentsArray]);
    }
}
