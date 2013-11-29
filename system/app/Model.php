<?
class Model
{
    private $_dir = '/model/';

    protected  $db;

    public function __construct()
    {
        $this->db = new Component_Db();
    }

    // ��������� �������
	private static $objects = array();
    
    
    // ���������� �����, ������� ������ ������ ������
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
