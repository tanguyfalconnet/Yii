<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Post;

class UpdatePostForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $title;

    /**
     * @var \common\models\User
     */
    private $_post;


    /**
     * Creates a form model given an id.
     *
     * @param  integer                         $id
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if id is not valid
     */
    public function __construct($id, $config = [])
    {
        $this->_post = Post::findOne(['id' => $id]);
        if (!$this->_post) {
            throw new InvalidParamException('Wrong id.');
        }
        $this->imageFile = $this->_post->image;
        $this->title = $this->_post->title;
        parent::__construct($config);
    }
    
    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'min' => 6]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('frontend', 'Title'),
        ];
    }
    
    public function update()
    {
        if ($this->validate()) {
            $this->_post->title = $this->title;
                return $post->save(); 
        }
        return false;
    }
}