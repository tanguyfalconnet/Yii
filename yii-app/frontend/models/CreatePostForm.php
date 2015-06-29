<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Post;

class CreatePostForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $title;

    public function rules()
    {
        return [
            [['title', 'imageFile'], 'required'],
            ['title', 'string', 'min' => 6],
            ['imageFile', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function create()
    {
        if ($this->validate()) {
            $post = new Post();
            $post->title = $this->title;
            $post->user_id = Yii::$app->user->id;
            if($post->save(false)){
                $post->image = base64_encode(file_get_contents($this->imageFile->tempName));
                return $post->save(); 
            }
        }
        return false;
    }
}