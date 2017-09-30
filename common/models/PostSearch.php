<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 *
 * @property string $authorName
 */
class PostSearch extends Post
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'content', 'tags', 'authorName'], 'safe'],
        ];
    }

    /**
     * 给一个model类添加自定义的属性，可以重写attributes函数.
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['authorName']);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        $dataProvider = new ActiveDataProvider([
            'query'     => $query,
            'pagination'=> [
                'pageSize'=> 10,
            ],
            'sort'=> [
                'defaultOrder'=> [
                    'id'=> SORT_DESC,
                ],
                //给nickName添加排序规则（方法一）
                'attributes'=> ['id', 'title','authorName'=>[
                    'asc'  => ['adminuser.nickname'=>SORT_ASC],
                    'desc' => ['adminuser.nickname'=>SORT_DESC],
                ]],
            ],
        ]);

        //块赋值，将输入的表单数据赋值给当前对象的属性
        $this->load($params);

        //判断输入的数据是否符合规则
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
//             $query->where(['id'=>50]); //如果验证不通过，就显示id为50的那一条记录 （屏蔽掉这一行，将显示所有记录）
            return $dataProvider;
        }

        $query->andFilterWhere([
            'post.id'          => $this->id,
            'post.status'      => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'author_id'   => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        $query->join('LEFT JOIN', 'adminuser', 'adminuser.id = post.author_id');
        $query->andFilterWhere(['like', 'adminuser.nickname', $this->authorName]);
//        var_dump($query);die;

        //给作者列增加排序规则(方法2)
//        var_dump($dataProvider->sort->attributes);die;
        /*$dataProvider->sort->attributes['authorName'] = [
            'asc'  => ['adminuser.nickname'=>SORT_ASC],
            'desc' => ['adminuser.nickname'=>SORT_DESC],
//            'label'=> 'authorName',
        ];*/
//        var_dump($dataProvider->sort->attributes);die;

        return $dataProvider;
    }
}
