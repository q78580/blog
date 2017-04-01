<?php
namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;

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

}