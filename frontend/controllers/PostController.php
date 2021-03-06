<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\Tag;
use common\models\User;
use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\caching\DbDependency;
use yii\db\Query;
use yii\filters\HttpCache;
use yii\filters\PageCache;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public $added=0; //0代表还没有新回复
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
            'pageCache'=>[
                'class'=>PageCache::className(),
                'only'=>['index'],
                'duration'=>70,
                'variations'=>[
                    Yii::$app->request->get('page'),
                    Yii::$app->request->get('PostSearch'),
                ],
                'dependency'=>[
                    'class'=>DbDependency::className(),
                    'sql'=>'select count(id) from post'
                ]
            ],
            'httpCache'=>[
                'class'=>HttpCache::className(),
                'only'=>['detail'],
                'lastModified'=>function($action,$params){
                    $query = new Query();
                    return $query->from('post')->max('update_time');
                },
                'etagSeed'=>function($action,$params){
                    $post = $this->findModel(Yii::$app->request->get('id'));
                    return serialize([$post->title,$post->content]);
                },
                'cacheControlHeader'=> 'public,max-age=180'
            ]
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $cache_comments = Yii::$app->cache->get('cacheComments');
//        if($cache_comments == false ){
            $comments= Comment::findRecentComments();
//            sleep(3);
//            Yii::$app->cache->set('cacheComments',$comments);
//        }
        $tags = Tag::findTagWeights();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tags'=> $tags,
            'comments'=>$comments
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
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
     * Deletes an existing Post model.
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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionDetail($id){
        $post = $this->findModel($id);

        $user = Yii::$app->user->identity;
        $recentComments = Comment::findRecentComments();
        $tags = Tag::findTagWeights();
        $commentModel = new Comment();
        $notice = '';

        //step2. 当评论提交时，处理评论
        if($user){
            $commentModel->email = $user->email;
            $commentModel->user_id = $user->id;
        }else{
            $notice = '请先登录,再进行评论.';
        }
        if($commentModel->load(Yii::$app->request->post()))
        {
            $commentModel->create_time = time();
            $commentModel->status = 1; //新评论默认状态为 pending
            $commentModel->post_id = $id;
            if($commentModel->save())
            {
                $this->added=1;
            }

        }
        return $this->render('detail',[
            'model'=>$post,
            'tags'=>$tags,
            'recentComments'=>$recentComments,
            'commentModel'=>$commentModel,
            'added'=>$this->added,
            'notice'=>$notice
        ]);
    }
}
