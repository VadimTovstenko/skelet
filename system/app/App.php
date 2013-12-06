<?
/**
 *  @author 	Anton Tovstenko
 *
 * Class App
 * Главный класс приложения.
 * Получает данные из адресной строки.
 * Определяет Контроллер и вызывает Действие
 * Выводит готовую страницу
 */
class App
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
        $url = new Url();

        // languages detect
        $lanCfg = Config::get('languages');
        // если включена мультиязичность
        if($lanCfg->status === true) {
            
            $language = new UrlOffsetLanguage();
            $language->init( $lanCfg, $url );
            self::$offset = $language->getOffset();
        }
        // languages detect end
        
        $controllerName	= (string) $url->get(0 + self::$offset, 'string');
        $actionName      = (string) $url->get(1 + self::$offset, 'string');

        $controllerName = ($controllerName)? strtolower($controllerName)	:  Config::get('default_controller');
        $actionName     	= ($actionName)?       strtolower($actionName)   	:  Config::get('default_action');
            
        self::init(array(
                    'controller' => $controllerName,
                    'action'     	=> $actionName,
                   ));
    }

    
    /**
     * Инициализация приложения
     * Определение контроллера и действия
     * @param array(
                'controller'	=> 'controllerName',
                'action'     	=> 'actionName',
                )
     * */
    public static function init(array $params)
    {
        if(!isset($params['controller']) || !isset($params['action'])) {
            die("Неправилно указаны праметры");
        }
        
        $controllerName	= $params['controller'];
        $actionName      = $params['action'];
        
        $controllerPath  	= ROOT."/controller/".$controllerName."Controller.php";

        if(file_exists($controllerPath))
        {   
            include_once $controllerPath;
            $className = ucfirst($controllerName).'Controller';
            
            if (class_exists($className)) {

                self::$controller = new $className();
                self::$actionName = $actionName."Action";
                        
                if (!method_exists(self::$controller,self::$actionName)) {
                    self::init(array('controller' =>'error', 'action' => 'index'));
                    Errors::add('method', "Метод <strong>$actionName</strong> не найден!");
                }
            }   
            else {
                self::init(array('controller' =>'error', 'action' => 'index'));
                Errors::add('class', "Класс <strong>$className</strong> не найден!");
            }
        }
        else {
            self::init(array('controller' =>'error', 'action' => 'index'));
            Errors::add('controller', "Контроллер <strong>$controllerName</strong> не найден!");
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

}
