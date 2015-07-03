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
            ['imageFile', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
        ];
    }
    
    public function create()
    {
        if ($this->validate()) {
            $post = new Post();
            $post->title = $this->title;
            $post->user_id = Yii::$app->user->id;
            if($post->save(false)){
                $path = 'uploads/' . $post->id . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs($path);
                $post->image = $path;
                return $post->save(); 
            }
        }
        return false;
    }
}