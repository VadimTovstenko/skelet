<?
class Config
{
    public $config = array();
    
    
    public function __construct(){
        require_once($_SERVER["DOCUMENT_ROOT"]."/config/config.php");  
        $this->config = $config;
    }
    
    public function get($paramName) 
    {   
        if(isset($this->config[$paramName])) {
            return $this->config[$paramName];
        }
        return null;
    }
    
}