<?php

namespace kouosl\muayene\models;

use Yii;

/**
 * This is the model class for table "muayenes".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $picture
 *
 * @property data[] $data
 */
class muayenes extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'muayenes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description', 'picture'], 'string'],
            [['title'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'picture' => 'Picture',
        ];
    }

    public function getImagePath(){
        return sprintf("%s/muayenes/%s",Yii::getAlias ( '@data' ),$this->picture);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getData()
    {
        return $this->hasMany(muayeneData::className(), ['muayene_id' => 'id']);
    }
}
