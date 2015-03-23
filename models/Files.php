<?php

namespace linchpinstudios\filemanager\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $url
 * @property string $thumbnail_url
 * @property string $file_name
 * @property string $type
 * @property string $title
 * @property integer $size
 * @property integer $width
 * @property integer $height
 * @property string $date
 * @property string $date_gmt
 * @property string $update
 * @property string $update_gmt
 *
 * @property FileTerms[] $fileTerms
 * @property User $user
 */
class Files extends \yii\db\ActiveRecord
{


    public function behaviors()
    {
        return [
            'modified' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'update',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update',
                ],
                'value' => function() {
                    return date('Y-m-d H:i:s');
                },
            ],
            'modifiedGMT' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'update_gmt',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_gmt',
                ],
                'value' => function() {
                    return gmdate('Y-m-d H:i:s');
                },
            ],
            'date' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'date',
                ],
                'value' => function() {
                    return (empty($this->date) ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s',strtotime($this->date)));
                },
            ],
            'dateGMT' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_gmt',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'date_gmt',
                ],
                'value' => function() {
                    return (empty($this->date) ? gmdate('Y-m-d H:i:s') : gmdate('Y-m-d H:i:s',strtotime($this->date)));
                },
            ],
        ];
    }



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'size', 'width', 'height'], 'integer'],
            [['date', 'date_gmt', 'update', 'update_gmt'], 'safe'],
            [['url', 'thumbnail_url', 'file_name', 'title'], 'string', 'max' => 555],
            [['type'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'url' => 'Url',
            'thumbnail_url' => 'Thumbnail Url',
            'file_name' => 'File Name',
            'type' => 'Type',
            'title' => 'Title',
            'size' => 'Size',
            'width' => 'Width',
            'height' => 'Height',
            'date' => 'Date',
            'date_gmt' => 'Date Gmt',
            'update' => 'Update',
            'update_gmt' => 'Update Gmt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileTerms()
    {
        return $this->hasMany(FileTerms::className(), ['file_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
