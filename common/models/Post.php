<?php
namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

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
            Tag::addFrequency(explode(',',$this->tags));
        }else{
            Tag::updateTags($this->tags,$this->_oldTags);
        }

        return parent::afterSave($insert, $changedAttributes);
    }
    public function afterDelete()
    {
        Tag::removeFrequency(explode(',',$this->tags));
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
            $links[] = Html::a(Html::encode($value),array('post/index',"PostSearch[tags]"=>$value));
        }
        return $links;
    }
    public function getCommentCount(){
        return Comment::find()->where(['post_id'=>$this->id])->count();
    }

    public function getActiveComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])
            ->where('status=:status',[':status'=>2])->orderBy('id DESC');
    }
}