<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Comment;

class CreateCommentForm extends Model
{
    public $text;
    
    public function rules()
    {
        return [
            ['text', 'string', 'min' => 2]
        ];
    }
    
    public function create($post_id)
    {
        if ($this->validate()) {
            $comment = new Comment();
            $comment->text = $this->text;
            $comment->post_id = $post_id;
            $comment->user_id = Yii::$app->user->id;
            return $comment->save();
        }
        return false;
    }
}