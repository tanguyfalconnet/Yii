<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\AuthentificationAssignment;
use common\models\Post;
use common\models\Comment;
use frontend\models\Notification;

/**
 * Smiley model
 *
 */
class Smiley
{
    private static $icons = [
        ':)'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':-)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':D'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':d'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ';)'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':P'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':-P'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':-p'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':p'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':('    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':o'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':O'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':0'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':|'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':-|'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':/'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        ':-/'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=)'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=-)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=D'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=d'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=P'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=P'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=p'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=('    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=o'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=O'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=0'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=|'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=-|'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=/'    =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '=-/'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '0=)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '0=-)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '0:)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        '0:-)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        'O=)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        'O=-)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        'O:)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        'O:-)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        'o=)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        'o=-)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        'o:)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
        'o:-)'   =>  '<img src="/images/emoticons/smile.png" alt="smile"/>',
    ];
    
    /**
     * Include emoticons in a text
     *
     * @param string $text to format
     * @return string
     */
    public static function emo($text)
    {
        if(!is_string($text))
        {
            return '';
        }
        foreach(Smiley::$icons as $icon=>$image) 
        {
          $text = str_replace($icon, $image, $text);
        }
        return $text;
    }
}
