<?php
namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\bootstrap\Html;

class Post extends _Post
{
    private $_oldTags;
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'createdAtAttribute'=> 'create_time',
                'updatedAtAttribute'=> 'update_time',
            ]
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            Tag::addFrequency($this->tags);
        }else{
            Tag::updateTags($this->tags,$this->_oldTags);
        }

        return parent::afterSave($insert, $changedAttributes);
    }
    public function afterDelete()
    {
        Tag::removeFrequency($this->tags);
        return parent::afterDelete();
    }
    public function getUrl(){
        return Yii::$app->urlManager->createUrl([
            'post/detail',
            'id'=>$this->id,
            'title'=>$this->title,
        ]);
    }
    public function getBeginning($length=288){
        $tmpStr = strip_tags($this->content);
        $tmpLen = mb_strlen($tmpStr);

        $tmpStr = mb_substr($tmpStr,0,$length,'utf-8');
        return $tmpStr.($tmpLen>$length?"...":'');
    }
    public function getTagLinks(){
        $links = [];
        $tags = Tag::formatName($this->tags);
        $tags = explode(',',$tags);
        foreach($tags as $value){
            $links[] = \yii\helpers\Html::a(Html::encode($value),array('post/index',"postSearch[tags]"=>$value));
        }
        return $links;
    }
    public function getCommentCount(){
        return Comment::find()->where(['post_id'=>$this->id])->count();
    }
}