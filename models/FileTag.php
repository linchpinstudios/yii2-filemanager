<?php

namespace linchpinstudios\filemanager\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use linchpinstudios\filemanager\helpers\StringHelper;
use linchpinstudios\filemanager\models\Files;

/**
 * This is the model class for table "{{%file_tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 */
class FileTag extends \yii\db\ActiveRecord
{

    /**
     * [behaviors description]
     * @return [type] [description]
     */
    public function behaviors()
    {
        return [
            'slug' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'slug',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'slug',
                ],
                'value' => function() {
                    return (empty($this->slug) ? StringHelper::genSlug($this->name) : StringHelper::genSlug($this->slug));
                },
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'URL Slug'),
        ];
    }


    /**
     * [getFiles description]
     */
    public function getFiles()
    {
        return $this->hasMany( Files::className(), ['id' => 'file_id'])
            ->viaTable( '{{%file_tag_relationships}}', ['tag_id' => 'id'], function($query){
                return $qurey->orderBy( 'sort' );
            });
    }



    public function getFirstfile()
    {
       return $this->hasMany( Files::className(), ['id' => 'file_id'])
            ->viaTable( '{{%file_tag_relationships}}', ['tag_id' => 'id'], function($query){
                return $query->orderBy( 'sort' );
            })
            ->limit(1);
    }


}
