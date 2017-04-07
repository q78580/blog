<?php
namespace common\models;
use Yii;
class Tag extends _Tag
{
    public static function updateTags($tags,$old_tags){
        if(!empty($tags) && !empty($old_tags)){
            $tags=self::formatName($tags);
            $old_tags=self::formatName($old_tags);
            $tags=explode(',',$tags);
            $old_tags=explode(',',$old_tags);
            $add = array_values(array_diff($tags,$old_tags));
            $remove = array_values(array_diff($old_tags,$tags));
            self::addFrequency($add);
            self::removeFrequency($remove);
        }
    }
    public static function addFrequency($add){
        if(empty($add)) return ;

        foreach($add as $name){
            $tag_model = \common\models\Tag::find()->where(['name'=>$name])->one();
            if($tag_model){
                $tag_model->frequency +=1;
            }else{
                $tag_model = new Tag();
                $tag_model->name = $name;
                $tag_model->frequency = 1;
            }
            $tag_model->save(false);
        }
        return true;
    }
    public static function removeFrequency($remove){
        if(empty($remove)) return ;
        foreach($remove as $name){
            $tag_model = \common\models\Tag::find()->where(['name'=>$name])->one();
            if($tag_model && $tag_model->frequency >1){
                $tag_model->frequency -=1;
                $tag_model->save();
            }else if($tag_model && $tag_model->frequency <=1){
                $tag_model->delete();
            }
        }
        return true;
    }
    public static function formatName($name){
        return trim($name);
    }
    public static function findTagWeights($limit = 20){
        $tag_size_level = 5;
        $model_tags = Tag::find()->orderBy('frequency')->limit($limit)->all();
        $total = count($model_tags);//15
        $stepper = ceil($total/$tag_size_level);//3
        $tags = [];
        $counter = 1;
        foreach($model_tags as $model){
            $weight = ceil($counter/$stepper)+1;
            $tags[$model->name] = $weight;
            $counter++;
        }
        return $tags;
    }
}