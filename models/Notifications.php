<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property integer $id
 * @property string $title
 * @property string $date
 * @property string $body
 * @property integer $from
 * @property integer $to
 * @property integer $trigger_id
 * @property integer $dismissed
 *
 * @property User $from0
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['body'], 'string'],
            [['from', 'trigger_id', 'dismissed', 'to'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['from'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from' => 'id']],
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
            'date' => 'Date',
            'body' => 'Body',
            'from' => 'From',
            'to' => 'To',
            'trigger_id' => 'Trigger ID',
            'dismissed' => 'Dismissed',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom0()
    {
        return $this->hasOne(User::className(), ['id' => 'from']);
    }
}
