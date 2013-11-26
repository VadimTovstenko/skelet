<?
class View
{
    private $view    = null;
    private $layout  = 'main';
    private $data    = array();
    private $content;
    
    
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    
    public function getLayout()
    {
        return $this->layout;
    }



    public function tpl($view)
    {
        $this->view = $view;
    }
    
    
    public function assign($key,$val)
    {
        $this->data[$key] = $val;
    }
    
    
    public function content($controllerName,$actionName)
    {
        if(!isset($this->view)){
            $this->view = substr($actionName,0,strpos($actionName,'Action'));
        }
        
        $controllerName = substr($controllerName,0,strpos($controllerName,'Controller'));
        
        ob_start();
        
        include $_SERVER["DOCUMENT_ROOT"].'/view/'.$controllerName.'/'.$this->view.'.html';
        
        $this->content = ob_get_contents();
        
        ob_clean();
        
        //return $this->content;
    }
    
    
    public function renderLayout()
    {
        ob_start();
        
        include $_SERVER["DOCUMENT_ROOT"].'/layout/'.$this->layout.'.html';
        
        $res = ob_get_contents();
        
        ob_clean();
        
        return $res;
    }
    
    
    
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        else {
            return false;
        }
    }

}

