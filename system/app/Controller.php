<?
class Controller
{
    public $view;
    public $model;
    public $request;
    public $language;
    
    public static $lang;
    
    
    
    public function __construct() {
        $this->view       = new View();
        $this->model     = new Model();
        $this->request   = new Request();
        $this->language = $this->getLanguage();
    }   
    
    
    
    public static function setLanguage($lang){
        self::$lang = $lang;
    }
    
    
    public function getLanguage(){
        return self::$lang;
    }
    
    
    
    public function createUrl(array $params)
    {
        $lang = null;
        if($this->language) {
            $lang = '/'.$this->language;
        }
        
        $url = '';
        foreach ($params as $param) {
            $url .= '/'.$param;
        }
        return $lang.$url;        
    }
    
    
    
    public function redirect($url)
    {
        header('location:'.$url);
        exit;
    }
    
    
    
    public function end() 
    {
        $db = new Component_Db();
        $db->close();
    }
}