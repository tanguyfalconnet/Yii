<?php
namespace common\models;


use common\models\AuthentificationAssignment;
use yii\db\ActiveRecord;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthentificationItem
 *
 * @author hp01ca
 */
class AuthentificationItem extends ActiveRecord{
    
    
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'auth_item';
    }
    
    public function getAuthentificationAssignments()
    {
        return $this->hasMany(AuthentificationAssignment::className(), ['item_name' => 'name']);
    }
    
    public static function findAll($condition) {
        return parent::findAll($condition);
    }

}
