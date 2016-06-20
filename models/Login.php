<?php
namespace app\models;
use yii\base\Model;
class Login extends Model
{
    public $email;
    public $password;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email','password'],'required'],
            ['email','email'],
            ['password','validatePassword'] //собственная функция для валидации пароля
        ];
    }

    /**
     * Выводит ошибку, если юзер не прошел авторизацию
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if(!$this->hasErrors()) // если нет ошибок в валидации
        {
            $user = $this->getUser();
            if(!$user || !$user->validatePassword($this->password))
            {
                $this->addError($attribute,'Пароль или имейл введены неверно');
                //добавляем новую ошибку для атрибута password о том что пароль или имейл введены не верно
            }
        }
    }

    /** Ишет юзера по email
     * @return null|static
     */
    public function getUser()
    {
        return User::findOne(['email'=>$this->email]); 
    }
}