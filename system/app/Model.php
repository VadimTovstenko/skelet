<?
class Model
{
    private $_dir = '/model/';
    
    // Созданные объекты
	private static $objects = array();
    
    
    // Магический метод, создает нужный объект Модели
	public function __get($name)
	{
		// Если такой объект уже существует, возвращаем его
		if (isset(self::$objects[$name])) {
			return(self::$objects[$name]);
		}
		
		// Определяем имя нужного класса
		$class = ucfirst(strtolower($name));
        $path  = $_SERVER["DOCUMENT_ROOT"].$this->_dir.$class.'.php';
        
        if(!file_exists($path))
            die("Модель <strong>$class</strong> не существует!");
		
		// Подключаем его
		include_once($path);

		// Сохраняем для будущих обращений к нему
		self::$objects[$name] = new $class();

		// Возвращаем созданный объект
		return self::$objects[$name];
	}   
    
}
