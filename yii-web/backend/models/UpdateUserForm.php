<?php
namespace backend\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\db\Query;

/**
 * Password reset form
 */
class UpdateUserForm extends Model
{
    public $username;
    public $displayed_name;
    public $email;
    public $password;
    public $role;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given an id.
     *
     * @param  integer                         $id
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if id is not valid
     */
    public function __construct($id, $config = [])
    {
        $this->_user = User::findIdentity($id);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong id.');
        }
        $this->username = $this->_user->username;
        $this->email = $this->_user->email;
        $this->displayed_name = $this->_user->displayed_name;
        if($this->role = $this->_user->authentificationAssignment){
            $this->role = $this->_user->authentificationAssignment->item_name;
        }
        $this->password = '****';
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'unique', 'filter' => ['not', ['id' => $this->getId()]], 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'filter' => ['not', ['id' => $this->getId()]],'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            
            ['displayed_name', 'filter', 'filter' => 'trim'],
            ['displayed_name', 'required'],
            ['displayed_name', 'unique', 'filter' => ['not', ['id' => $this->getId()]],'targetClass' => '\common\models\User', 'message' => 'This displayed name has already been taken.'],
            ['displayed_name', 'compare', 'compareAttribute' => 'username', 'operator' => '!=', 'message' => 'This displayed name shall be different than username.'],
            ['displayed_name', 'string', 'min' => 2, 'max' => 255],
            
            ['displayed_name', 'filter', 'filter' => 'trim'],
            ['displayed_name', 'unique', 'filter' => ['not', ['id' => $this->getId()]], 'targetClass' => '\common\models\User', 'message' => 'This displayed name has already been taken.'],
            ['displayed_name', 'compare', 'compareAttribute' => 'username', 'operator' => '!=', 'message' => 'This displayed name shall be different than username.'],
            ['displayed_name', 'string', 'min' => 2, 'max' => 255],
            
            ['password', 'string'],
            
            [['username', 'email', 'role', 'displayed_name'], 'required']
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if user is updated.
     */
    public function update()
    {
        if($this->validate()){
            $user = $this->_user;
            if(!empty($this->password) && strlen($this->password) >= 6){
                $user->setPassword($this->password);
            }
            if(!empty($this->email)){
                $user->email = $this->email;
            }
            if(!empty($this->username)){
                $user->username = $this->username;
            }
            if(!empty($this->displayed_name)){
                $user->displayed_name = $this->displayed_name;
            }
            $this->role = $this->getAvailableRoles()[$this->role];
            return $user->save();
        }
        
        return false;
    }
    
    public function getId()
    {
        return $this->_user->getId();
    }
    
    public function getAvailableRoles() {
        $query = new Query;
        // compose the query
        $query->select('name')
            ->from('auth_item')
            ->where(['type'=>'1']);
        // build and execute the query
        // put currently user role at first 
        $availableRoles = $query->column();
        $index = array_search($this->role, $availableRoles);
        $out = array_splice($availableRoles, 0, 1);
        array_splice($availableRoles, $index, 0, $out);
        return $availableRoles;
    }
}
