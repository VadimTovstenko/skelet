<?
class App
{
    
    private static $controller;
    private static $actionName;

    public static $offset = 0;
    
    public function __construct()
    {      
        $url   = new Url();

        //-- languages detect 
        $lanCfg = Config::get('languages');
        // если включена мультиязичность
        if($lanCfg['status'] === true) {
            
            $language = new Language();
            $language->init( $lanCfg, $url );
            self::$offset   = $language->getOffset();
        }
        //-- languages detect end
        
        $controllerName = (string) $url->get(0 + self::$offset);
        $actionName      = (string) $url->get(1 + self::$offset);

        $controllerName = ($controllerName)? strtolower($controllerName) :  Config::get('default_controller');
        $actionName     = ($actionName)?       strtolower($actionName)     :   Config::get('default_action');
            
        self::init(array(
                    'controller' => $controllerName,
                    'action'     => $actionName,
                   ));
    }
    

    
    /**
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
        
        $controllerName  = $params['controller'];
        $actionName      = $params['action'];
        
        $controllerPath  = ROOT."/controller/".$controllerName."Controller.php";

        if(file_exists($controllerPath))
        {   
            include_once $controllerPath;
            $className = ucfirst($controllerName).'Controller';
            
            if (class_exists($className)) {

                self::$controller = new $className();
                self::$actionName = $actionName."Action";
                        
                if (!method_exists(self::$controller,self::$actionName)) {
                    die("Метод <strong>$actionName</strong> не найден!");
                }
            }   
            else {
                die("Класс <strong>$className</strong> не найден!");
            }
        }
        else {
            die("Контроллер <strong>$controllerName</strong> не найден!");
        }
    }
    
    
    
    /**
     * Запуск приложения.
     * Визивается установленное действие контроллера.
     * Формируется представление и подставляется в главный шаблон (layout)                
     * @return готовая страница.
     * */
    public static function run()
    {  
        $action     = self::$actionName;
        $controller = self::$controller;
        
        if(method_exists($controller,'init')) {
            $controller->init();
        }
        
        $controller->$action(); 
        $controller->view->content(get_class($controller),$action);
        
        print $controller->view->renderLayout();
        
    }
    
    
    /**
     * запускается при завершении работы скрипта
     * */   
    public static function end()
    {
        //завершаем работу контроллера
        $cont = new Controller();
        $cont->end();
    }

}
