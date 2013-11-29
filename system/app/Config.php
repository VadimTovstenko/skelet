<?
/**
 *  @author 	Anton Tovstenko
 *
 * Class Config
 * ��������
 * ����� ��� ��������� ���������� �� ����������������� �����
 */
class Config
{

    private static $instance;


    /**
     * ��������� ���������� ������������
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
     * �����������
     * @return mixed
     */
    public static function getInstance(){
        if (!isset(self::$instance)) {
            if(!file_exists(ROOT.'/config/config.php')) {
                die('������ �� ������!');
            }
            require_once(ROOT."/config/config.php");
            self::$instance = $config;

        }
        return self::$instance;
    }
}