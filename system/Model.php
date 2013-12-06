<?
/**
 * Class Model
 * ������� ����������� � ��
 * ���� ������ � ������� ����� �������� ���������� ������
 *      ������:
 *      $model = new System_Model();
 *      $users = $model->users;
 *
 * @author Anton Tovstenko *
 */
class  System_Model
{

    /**
     * ����� �������� �������
     * @var string
     */
    private $_dir = '/model/';


    /**
     * ��������� ���������� ��� ������ � ��
     * @var Component_Db
     */
    protected  $db;


    /**
     * ��������� ������� �������
     * @var array
     */
    private static $objects = array();


    /**
     * ����������� ������
     */
    public function __construct()
    {
        $this->db = Component_Db::getInstance();
    }


    /**
     * ���������� �����, ������� ������ ������ ������
     * @param $name
     * @return mixed
     */
    public function __get($name)
	{
		// ���� ����� ������ ��� ����������, ���������� ���
		if (isset(self::$objects[$name])) {
			return(self::$objects[$name]);
		}
		
		// ���������� ��� ������� ������
		$class = ucfirst(strtolower($name));
        $path  = ROOT.$this->_dir.$class.'.php';
        
        if(!file_exists($path))
            die("������ <strong>$class</strong> �� ����������!");
		
		// ���������� ���
		include_once($path);

		// ��������� ��� ������� ��������� � ����
		self::$objects[$name] = new $class();

		// ���������� ��������� ������
		return self::$objects[$name];
	}   


}
