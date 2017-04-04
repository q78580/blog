<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `common\models\Comment`.
 */
class CommentSearch extends Comment
{
    public function attributes()
    {
        return array_merge(parent::attributes(),['username','post_title']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'user_id', 'post_id'], 'integer'],
            [['content', 'email', 'url' ,'username','post_title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'comment.id' => $this->id,
            'comment.status' => $this->status,
            'comment.create_time' => $this->create_time,
            'comment.user_id' => $this->user_id,
            'comment.post_id' => $this->post_id,
        ]);

        $query->andFilterWhere(['like', 'comment.content', $this->content])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'url', $this->url]);
        $query->join('INNER JOIN','user','user.id = comment.user_id');

        $query->andFilterWhere(['like','user.username',$this->username]);
        $dataProvider->sort->attributes['username']=[
            'asc'=>['user.username'=>SORT_ASC],
            'desc'=>['user.username'=>SORT_DESC],
        ];
        $query->join('INNER JOIN','post','post.id = comment.post_id');
        $query->andFilterWhere(['like','post.title',$this->post_title]);
        $dataProvider->sort->attributes['post_title']=[
            'asc'=>['post.title'=>SORT_ASC],
            'desc'=>['post.title'=>SORT_DESC],
        ];
        $dataProvider->sort->defaultOrder=[
            'status'=>SORT_ASC,
            'id'=>SORT_DESC,
        ];

        return $dataProvider;
    }
}
