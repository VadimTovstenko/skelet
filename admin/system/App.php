<?
/**
 *  @author 	Anton Tovstenko
 *
 * Class Admin
 * Главный класс приложения.
 * Получает данные из адресной строки.
 * Определяет Контроллер и вызывает Действие
 * Выводит готовую страницу
 */
class Admin_System_App
{


    /**
     * Экземпляр вызываемого Контроллера
     * @var controller
     */
    private static $controller;



    /**
     * Название вызываемого контроллера
     */
    private static $actionName;


    /**
     * Смещение параметров Url-адреса
     * Зависит от параметра языковой локали
     * @var int
     */
    public static $offset = 0;


    /**
     * Коструктор приложения
     * Автоматическое определение Контроллера и Действия
     */
    public function __construct()
    {
        $url   = new System_Url();

        $controllerName 	= (string) $url->get(0 + self::$offset, 'string');
        $actionName      = (string) $url->get(1 + self::$offset, 'string');

        $controllerName 	= ($controllerName)?	strtolower($controllerName) 	:  	System_Config::get('admin_default_controller');
        $actionName     	= ($actionName)?      	strtolower($actionName)     		:	System_Config::get('admin_default_action');

        self::init(array(
            'controller' 	=> $controllerName,
            'action'     	=> $actionName,
        ));
    }


    /**
     * Инициализация приложения
     * Определение контроллера и действия
     * @param array(
    'controller' => 'controllerName',
    'action'     => 'actionName',
    )
     * */
    public static function init(array $params)
    {
        if(!isset($params['controller']) || !isset($params['action'])) {
            die("Неправилно указаны праметры");
        }

        $controllerName	= $params['controller'];
        $actionName      = $params['action'];

        $controllerPath  	= ROOT."/admin/controller/".$controllerName."Controller.php";

        if(file_exists($controllerPath))
        {
            include_once $controllerPath;
            $className = ucfirst($controllerName).'Controller';

            if (class_exists($className)) {

                self::$controller 		= new $className();
                self::$actionName 	= $actionName."Action";

                if (!method_exists(self::$controller,self::$actionName)) {
                    self::init(array('controller' =>'error', 'action' => 'index'));
					System_Errors::add('method', "Метод <strong>$actionName</strong> не найден!");
                }
            }
            else {
                self::init(array('controller' =>'error', 'action' => 'index'));
				System_Errors::add('class', "Класс <strong>$className</strong> не найден!");
            }
        }
        else {
            self::init(array('controller' =>'error', 'action' => 'index'));
			System_Errors::add('controller', "Контроллер <strong>$controllerName</strong> не найден!");
        }
    }


    /**
     * Запуск приложения.
     * Визивается установленное действие контроллера.
     * Формируется представление и подставляется в главный шаблон (layout)
     * Вывод готовой страницы.
     * @return void
     */
    public static function run()
    {
        $action     	= self::$actionName;
        $controller = self::$controller;

        if(method_exists($controller,'init')) {
            $controller->init();
        }

        $controller->$action();
        $controller->view->content(get_class($controller),$action);

        print $controller->view->renderLayout();

    }


	/**
	 * Получение имени текущего контроллера
	 * @return string
	 */
	public static function getControllerName()
	{
		$name = get_class(self::$controller);
		return strtolower( substr( $name , 0 , strpos( $name , 'Controller' ) ) );
	}


	/**
	 * Получение имени текущего действия
	 * @return mixed
	 */
	public static function setActionName()
	{
		$name = self::$actionName;
		return substr( $name, 0 , strpos( $name , 'Action' ) );
	}
}
