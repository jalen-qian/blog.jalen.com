<?php

namespace common\models;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property int $status
 * @property int $create_time
 * @property int $update_time
 * @property int $author_id
 * @property Comment[] $comments
 * @property Adminuser $author
 * @property Poststatus $postStatus
 * @property string $aaa
 */
class Post extends \yii\db\ActiveRecord
{
    private $oldTags;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status', 'author_id'], 'required'],
            [['content', 'tags'], 'string'],
            [['status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => '标题',
            'authorName'  => '作者',
            'content'     => '内容',
            'tags'        => '标签',
            'status'      => '状态',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'author_id'   => '作者',
        ];
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Adminuser::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostStatus()
    {
        return $this->hasOne(Poststatus::className(), ['id' => 'status']);
    }

    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $this->create_time = time();
            $this->update_time = time();
        } else {
            $this->update_time = time();
        }

        return true;
    }

    /**
     * 重写.
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->oldTags = $this->tags;
    }

    /**
     * @param bool  $insert
     * @param array $changeAttributes
     */
    public function afterSave($insert, $changeAttributes)
    {
        parent::afterSave($insert, $changeAttributes);
        Tag::updateFrequency($this->oldTags, $this->tags);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Tag::updateFrequency($this->tags, '');
    }

}
