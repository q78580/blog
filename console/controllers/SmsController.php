<?php
namespace console\controllers;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10 0010
 * Time: 下午 3:32
 */
use common\models\Comment;
use yii;

class SmsController extends yii\console\Controller{

    public function actionSend(){
        $comments = Comment::find()->where(['remind'=>0,'status'=>1])->count();
        if($comments>0){
            $content = 'We have '.$comments.'comments  unCheck';
            $result = $this->vendorSmsService($content);
            if($result['status'] == 'success'){
                Comment::updateAll(['remind'=>2]);
            }
        }
        echo $comments.'comments  was checked'."\n";
        return 0;
    }
    public function vendorSmsService($content){
        $status =  Comment::updateAll(['remind'=>1,'status'=>2],['remind'=>0,'status'=>1]);
        $result = [];
        if($status){
            $result['dt'] = time();
            $result['status'] = 'success';
        }else{
            $result['status'] = 'failed';
        }

        return $result;
    }
}