<?
/**
 *  @author 	Anton Tovstenko
 *
 * Class Config
 * Синглтон
 * Класс для получения параметров из конфигурационного файла
 */
class Config
{

    private static $instance;


    /**
     * Получение параметров конфигурации
     * @param $paramName
     * @return mixed
     */
    public static function get($paramName)
    {
        if (!isset(self::$instance)) {
            self::getInstance();
        }

        if ( isset(self::$instance[$paramName]) ) {
            return self::$instance[$paramName];
        }
        return null;
    }


    /**
     * Определение
     * @return mixed
     */
    public static function getInstance(){
        if (!isset(self::$instance)) {
            if(!file_exists(ROOT.'/config/config.php')) {
                die('Конфиг не найден!');
            }
            require_once(ROOT."/config/config.php");
            self::$instance = $config;

        }
        return self::$instance;
    }
}