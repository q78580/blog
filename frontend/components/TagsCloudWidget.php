<?php
namespace frontend\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class TagsCloudWidget extends Widget
{
    public $tags;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $tagString='';
        $fontStyle=array(
            "6"=>"danger",
            "5"=>"info",
            "4"=>"warning",
            "3"=>"primary",
            "2"=>"success",
        );
        foreach ($this->tags as $tag=>$weight)
        {
            $options = [
                'class' => 'label label-'.$fontStyle[$weight],
            ];
            $option = [
                'style' => 'display:inline-block',
            ];

            $tagString .=  Html::a(Html::tag('h'.$weight,Html::tag('span', $tag, $options),$option),Url::to(['post/index','PostSearch[tags]'=>$tag]))."&nbsp&nbsp";
        }
        sleep(3);
        return $tagString;

    }









}