<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "triggers".
 *
 * @property integer $id
 * @property string $name
 * @property string $model
 * @property string $eventCode
 * @property integer $from
 * @property integer $to
 * @property string $title
 * @property string $type
 * @property string $body
 */
class Triggers extends \yii\db\ActiveRecord
{
    //public $model;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'triggers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['from'], 'integer'],
            [['body'], 'string'],
            [['name', 'eventCode', 'title', 'model', 'to'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'model' => 'Model Connected',
            'eventCode' => 'Event Code',
            'from' => 'From',
            'to' => 'To',
            'title' => 'Title',
            'type' => 'Type',
            'body' => 'Body',
        ];
    }
}
