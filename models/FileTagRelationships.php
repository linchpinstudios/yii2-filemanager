<?php

namespace linchpinstudios\filemanager\models;

use Yii;

/**
 * This is the model class for table "{{%file_tag_relationships}}".
 *
 * @property integer $id
 * @property integer $file_id
 * @property integer $tag_id
 */
class FileTagRelationships extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file_tag_relationships}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id', 'tag_id'], 'required'],
            [['file_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_id' => Yii::t('app', 'File ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
        ];
    }
}
