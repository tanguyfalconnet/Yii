<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;
use yii\db\Query;

/**
 * Signup form
 */
class CreateUserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;
    
    
        /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['role', 'required'],
            ['role', 'string'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
    
    
    public function getAvailableRoles() {
        $query = new Query;
        // compose the query
        $query->select('name')
            ->from('auth_item')
            ->where(['type'=>'1']);
        // build and execute the query
        return $query->column();
    }


}
