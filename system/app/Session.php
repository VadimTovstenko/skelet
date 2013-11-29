<?
class Session
{

    /**
     * @param $name
     * @return null
     */
    public static function getParam( $name )
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }


    /**
     * @param $name
     * @param $value
     */
    public static function setParam( $name, $value )
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param $name
     */
    public static function delParam( $name )
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }


    public static function destroy()
    {
        session_destroy();
    }


    public static function show()
    {
        print '<pre>';
        print_r($_SESSION);
        print '</pre>';
    }


}