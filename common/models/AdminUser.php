<?php
namespace common\models;
use Yii;

class AdminUser extends _AdminUser
{
    public function privilege($post){
        AuthAssignment::deleteAll(['user_id'=>$this->id]);
        foreach($post as $value){
            $ass = new AuthAssignment();
            $ass->user_id = $this->id;
            $ass->item_name = $value;
            $ass->created_at = time();
            $ass->save(false);
        }
        return true;
    }
}