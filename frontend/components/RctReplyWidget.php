<?php
namespace frontend\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class RctReplyWidget extends Widget
{
    public $comments;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $commentString='';

        foreach ($this->comments as $comment)
        {
            $commentString .=  Html::tag('div',Html::tag('div',Html::tag('p',"($comment->content)",['style' => 'color:#777777;font-style:italic']).Html::tag('p',Html::tag('span',Html::encode($comment->user->username),['class'=>'glyphicon glyphicon-user','aria-hidden'=>'ture']),['class'=>'text']).Html::tag('p',"《".Html::a(Html::encode($comment->post->title),$comment->post->url)."》",['style'=>'font-size:8pt;color:blue']),['class' => 'title']),['class' => 'post']);
        }
        return $commentString;

    }









}