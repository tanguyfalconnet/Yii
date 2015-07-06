<?php
namespace common\models;


/**
 * Smiley model
 *
 */
class Smiley
{
    public static $TITLE = 'title';
    public static $COMMENT = 'comment';
    private static $icons = [
        '=-/'   =>  'trav',
        '0=)'   =>  'angel',
        '0=-)'   =>  'angel',
        '0:)'   =>  'angel',
        '0:-)'   =>  'angel',
        'O=)'   =>  'angel',
        'O=-)'   =>  'angel',
        'O:)'   =>  'angel',
        'O:-)'   =>  'angel',
        'o=)'   =>  'angel',
        'o=-)'   =>  'angel',
        'o:)'   =>  'angel',
        'o:-)'   =>  'angel',
        ':-)'   =>  'smile',
        ':-P'   =>  'tounge',
        ':-p'   =>  'tounge',
        ':-|'   =>  'straight',
        ':-/'   =>  'trav',
        '=-)'   =>  'smile',
        '=-|'   =>  'straight',
        ':D'    =>  'smile',
        ':d'    =>  'smile',
        ':)'    =>  'smile',
        ';)'    =>  'wink',
        ':P'    =>  'tounge',
        ':p'    =>  'tounge',
        ':('    =>  'sad',
        ':o'    =>  'shock',
        ':O'    =>  'shock',
        ':0'    =>  'shock',
        ':|'    =>  'straight',
        ':/'    =>  'trav',
        '=)'    =>  'smile',
        '=D'    =>  'smile',
        '=d'    =>  'tounge',
        '=P'    =>  'tounge',
        '=P'   =>  'tounge',
        '=p'   =>  'tounge',
        '=('    =>  'sad',
        '=o'    =>  'shock',
        '=O'    =>  'shock',
        '=0'    =>  'shock',
        '=|'    =>  'straight',
        '=/'    =>  'trav',
    ];
    
    /**
     * Include emoticons in a text
     *
     * @param string $text to format
     * @param string Smiley::$TITLE|$COMMENT
     * @return string
     */
    public static function emo($text, $size = '')
    {
        if(!is_string($text) || !is_string($size))
        {
            return '';
        }
        foreach(Smiley::$icons as $icon=>$image) 
        {
            if($size == Smiley::$TITLE)
            {
                $replace = '<img style="width : 45px;" ';
            }else if($size == Smiley::$COMMENT)
            {
                $replace = '<img style="width : 35px;" ';
            }else{
                '<img ';
            }
            $replace .=  'src="/images/emoticons/'.$image.'.png" alt="smile"/>';
            $text = str_replace($icon, $replace, $text);
        }
        return $text;
    }
}
