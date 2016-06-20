<?php
namespace app\models;
use yii\base\Model;
class Signup extends Model
{
    public $email;
    public $password;
    public $role;
    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email','password', 'name', 'role'],'required'],
            ['email','email'],
            ['name','string','min'=>2,'max'=>50],
            ['email','unique','targetClass'=>'app\models\User'],
            ['password','string','min'=>2,'max'=>10]
        ];
    }

    /**
     * Создаёт в БД нового пользователя
     * @return bool
     */
    public function signup()
    {
        $user = new User();
        $user->email = $this->email;
        $user->role = $this->role;
        $user->name = $this->name;
        $user->setPassword($this->password);
        return $user->save(); //вернет true или false
    }
}