<?
class App
{
    
    private static $controller;
    private static $actionName;
    
    
    public function __construct()
    {      
        $url    = new Url();
        $config = new Config();

        //-- languages detect 
        $lanCfg = $config->get('languages');
        $offset  = 0;
        // ���� �������� ���������������
        if($lanCfg['status'] === true) {
            
            $language = new Language();
            $language->init($lanCfg,$url);
            $offset   = $language->getOffset();
        }
        //-- languages detect end
        
        $controllerName = (string) $url->get(0 + $offset);
        $actionName      = (string) $url->get(1 + $offset);
        
        $controllerName = ($controllerName)? strtolower($controllerName) : $config->get('default_controller');
        $actionName     = ($actionName)?       strtolower($actionName)     : $config->get('default_action');
            
        self::init(array(
                    'controller' => $controllerName,
                    'action'     => $actionName,
                   ));
    }
    

    
    /**
     * ����������� ����������� � ��������
     * @param array(
                'controller' => 'controllerName',
                'action'     => 'actionName',
                )
     * */
    public static function init(array $params)
    {
        if(!isset($params['controller']) || !isset($params['action'])) {
            die("���������� ������� ��������");
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
                    die("����� <strong>$actionName</strong> �� ������!");
                }
            }   
            else {
                die("����� <strong>$className</strong> �� ������!");
            }
        }
        else {
            die("���������� <strong>$controllerName</strong> �� ������!");
        }
    }
    
    
    
    /**
     * ������ ����������.
     * ���������� ������������� �������� �����������.
     * ����������� ������������� � ������������� � ������� ������ (layout)                
     * @return ������� ��������.
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
     * ����������� ��� ���������� ������ �������
     * */   
    public static function end()
    {
        //��������� ������ �����������
        $cont = new Controller();
        $cont->end();
    }

}
