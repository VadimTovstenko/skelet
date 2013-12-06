<?
/**
 * @author 	Anton Tovstenko
 *
 * Class Errors
 * Класс для работы с ошибками
 */
class Errors
{

    /**
     * Массив для хранения ошибок
     * errorName => errorMessage
     * @var array
     */
    private static $errors = array();


    /**
     * Добавление ошибки
     * @param $name
     * @param $mess
     */
    public static function add($name,$mess)
    {
        self::$errors[$name] = $mess;
    }



    /**
     * Получение сообщения ошибки по названию
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
     * Проверка наличия ошибок
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
     * Получение всего массива ошибок
     * @return array
     */
    public static function getAll()
    {
        return self::$errors;
    }


    /**
     * Ошибка 404
     */
    public static function error404()
    {
        Admin::init(array('controller' =>'error', 'action' => 'error404'));
        Admin::run();
        exit;
    }


}