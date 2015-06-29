<?php
namespace common\models;

use common\models\User;
use common\models\AuthentificationItem;
use yii\db\ActiveRecord;

/**
 * Description of AuthentificationAssignement
 *
 * @author hp01ca
 */
class AuthentificationAssignment extends ActiveRecord{
    
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }
    
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id']);
    }
    
    public function getAuthentificationItem()
    {
        return $this->hasOne(AuthentificationItem::className(), ['name' => 'item_name']);
    }
}
