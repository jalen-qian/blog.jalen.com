<?php

namespace common\models;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name
 * @property int $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'name'      => 'Name',
            'frequency' => 'Frequency',
        ];
    }

    /**
     * 处理需要增加的标签.
     *
     * @param $tags array
     */
    public static function addTags($tags)
    {
        if (empty($tags)) {
            return;
        }
        foreach ($tags as $name) {
            $aTag      = self::find()->where(['name'=>$name])->one();
            $aTagCount = self::find()->where(['name'=>$name])->count();
            if (!$aTagCount) {
                $tag            = new self();
                $tag->name      = $name;
                $tag->frequency = 1;
                $tag->save();
            } else {
                $aTag->frequency += 1;
                $aTag->save();
            }
        }
    }

    /**
     * 移除标签.
     *
     * @param $tags
     */
    public static function removeTags($tags)
    {
        if (empty($tags)) {
            return;
        }
        foreach ($tags as $name) {
            $aTag      = self::find()->where(['name'=>$name])->one();
            $aTagCount = self::find()->where(['name'=>$name])->count();
//            var_dump($aTag,$aTagCount);die;
            if ($aTagCount) {
                if ($aTag->frequency <= 1) {
                    $aTag->delete();
                } else {
                    $aTag->frequency -= 1;
                    $aTag->save();
                }
            }
        }
    }

    /**
     * 更新标签数量.
     *
     * @param $oldTags
     * @param $newTags
     */
    public static function updateFrequency($oldTags, $newTags)
    {
        if (!empty($oldTags) || !empty($newTags)) {
            $oldTagsArray = self::string2array($oldTags);
            $newTagsArray = self::string2array($newTags);
            self::addTags(array_values(array_diff($newTagsArray, $oldTagsArray)));
            self::removeTags(array_values(array_diff($oldTagsArray, $newTagsArray)));
        }
    }

    /**
     * 利用正则将字符串转换为数组.
     *
     * @param $tags
     *
     * @return mixed
     */
    private function string2array($tags)
    {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * 数组转换为字符串.
     *
     * @param $tags
     *
     * @return mixed
     */
    private function array2string($tags)
    {
        return implode(',', $tags);
    }
}
