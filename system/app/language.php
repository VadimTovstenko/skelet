<?
class Language
{  
    private $languages;
    private $language;
    private $offset;
    
    public function __construct()
    {
        /* auto detect
        if (($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
            if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                $this->language = array_combine($list[1], $list[2]);
                foreach ($this->language as $n => $v)
                    $this->language[$n] = $v ? $v : 1;
                arsort($this->language, SORT_NUMERIC);
            }
        } else $this->languages = array();
        */
    } 
    
    public function init($config,$url) {
                
        if($url->get(0)) {
           
            if(in_array($url->get(0),$config['list'])){
                $this->offset   = 1;
                $this->language = $url->get(0);
            }
            else {
                $this->offset   = 0;
                $this->language = $config['default'];
            }  
        } 
        else {
            $this->language = $config['default'];
        }
        
        Controller::setLanguage($this->language);
        
        return $this->offset;

    }
    
    public function getLaguages() {
        return $this->language;
    }
    
    
    public function getOffset() {
        return $this->offset;
    }
    
    
    
    
    
}