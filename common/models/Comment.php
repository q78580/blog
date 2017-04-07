<?php
namespace common\models;
use Yii;
class Comment extends _Comment
{
    public function getCont(){
        $tmpStr = strip_tags($this->content);//剥去html标签
        $tmpLen = mb_strlen($tmpStr);//汉字截取mb_
        return mb_substr($tmpStr,0,10,'utf-8').(($tmpLen>20?"...":''));
    }
    public function check(){
        $this->status = 2;
        return $this->save()?true:false;
    }
    public static function getUnCheckCount(){
        return Comment::find()->where(['status'=>1])->count();
    }
    public static function findRecentComments($limit = 10){
        return Comment::find()->where(['status'=>2])->orderBy('create_time')->limit($limit)->all();
    }
}