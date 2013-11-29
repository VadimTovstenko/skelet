<?
class Errors
{
    private static $errors = array();
    
    public static function add($name,$mess)
    {
        self::$errors[$name] = $mess;
    }
    
    public static function get($name)
    {
        if ( isset(self::$errors[$name]) ) {
            return self::$errors[$name];
        }

    }

    
}