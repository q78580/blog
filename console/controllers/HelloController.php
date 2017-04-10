<?php
namespace console\controllers;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10 0010
 * Time: 下午 3:08
 */
class HelloController extends \yii\console\Controller{

    public function actionIndex(){
        echo "Hello World by console";
    }
}