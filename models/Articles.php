<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property integer $author
 * @property string $shorttext
 * @property string $text
 *
 * @property User $author0
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['author'], 'integer'],
            [['text'], 'string'],
            [['title', 'authorName'], 'string', 'max' => 50],
            [['shorttext'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
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
            'author' => 'Author',
            'shorttext' => 'Short Text',
            'text' => 'Text',
            'authorName' => 'Author Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    /**
     * Возвращает имя автора статьи из таблицы User
     * @return mixed
     */
    public function getAuthorName() {
        $ret = User::find()->where(['id' => $this->author])->addSelect('name')->asArray()->one();
        //var_dump($ret);
        return $ret['name'];
    }

    //следующие функции добавляем в классы, чьи события хотим отслеживать (php>=5.6)
    /**
     * Возвращает имена доступных в классе событий (константы вида "EVENT_*")
     * @return array
     */
    public static function getEvents(){
        $oClass = new \ReflectionClass(__CLASS__);
        return array_filter($oClass->getConstants(), function ($var) {return preg_match("/^EVENT_/", $var);}, ARRAY_FILTER_USE_KEY);
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'triggered' => [ //поведение для классов, к которым цепляем триггеры
                'class' => 'app\models\Triggered'
            ]
        ];
    }
}
