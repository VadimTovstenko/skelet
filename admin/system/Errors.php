<?
/**
 * @author 	Anton Tovstenko
 *
 * Class Errors
 * ����� ��� ������ � ��������
 */
class Errors
{

    /**
     * ������ ��� �������� ������
     * errorName => errorMessage
     * @var array
     */
    private static $errors = array();


    /**
     * ���������� ������
     * @param $name
     * @param $mess
     */
    public static function add($name,$mess)
    {
        self::$errors[$name] = $mess;
    }



    /**
     * ��������� ��������� ������ �� ��������
     * @param $name
     * @return bool
     */
    public static function get($name)
    {
        if ( isset(self::$errors[$name]) ) {
            return self::$errors[$name];
        }
        return false;
    }


    /**
     * �������� ������� ������
     * @return bool
     */
    public static function isErrors()
    {
        if ( !empty( self::$errors ) ) {
            return true;
        }
        return false;
    }


    /**
     * ��������� ����� ������� ������
     * @return array
     */
    public static function getAll()
    {
        return self::$errors;
    }


    /**
     * ������ 404
     */
    public static function error404()
    {
        Admin::init(array('controller' =>'error', 'action' => 'error404'));
        Admin::run();
        exit;
    }


}