<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
class User extends ActiveRecord implements IdentityInterface
{
    public function setPassword($password)
    {
        $this->password = sha1($password);
    }
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }
    //=============================================
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }
    public function getId()
    {
        return $this->id;
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }
    public function getAuthKey()
    {
    }
    public function validateAuthKey($authKey)
    {
    }
    public function getNameAdress(){
        return $this->name.' <'.$this->email.'>';
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