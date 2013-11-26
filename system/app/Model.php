<?
class Model
{
    private $_dir = '/model/';
    
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
        $path  = $_SERVER["DOCUMENT_ROOT"].$this->_dir.$class.'.php';
        
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
