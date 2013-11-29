<?
class Controller
{

    public $view;
    public $model;
    public $language;

    public static $lang;


    public function __construct() {

        $this->view              = new View();
        $this->view->cache   = new Cache();

        $this->language        = $this->getLanguage();
    }


    /**
     * @param $lang
     */
    public static function setLanguage($lang){
        self::$lang = $lang;
    }


    /**
     * @return mixed
     */
    public function getLanguage(){
        return self::$lang;
    }



    /**
     * @param array $params
     * @return string
     */
    public function createUrl(array $params)
    {
        $lang = null;
        if(self::$lang) {
            $lang = '/'.self::$lang;
        }
        
        $url = '';
        foreach ($params as $param) {
            $url .= '/'.$param;
        }
        return $lang.$url;        
    }


    /**
     * @param $url
     */
    public function redirect($url)
    {
        header('location:'.$url);
        exit;
    }


    /**
     * @param array $params
     */
    public function call(array $params)
    {
        App::init($params);
        App::run();
    }



    public function end() 
    {
        $db = new Component_Db();
        $db->close();
    }


    /**
     * @return int
     */
    private  function _getOffset()
    {
        return App::$offset;
    }


    /**
     * Получение параметров из адресной строки
     * отсчет начинается после Action, с нуля
     * @param $urlOffset
     * @return bool
     */
    public function getUrlParam( $urlOffset, $type = null )
    {
        /**
         *смещение для /controller/action
         * @var $default_offset int */
        $default_offset = 2;

        $url = new Url();
        return $url->get( $urlOffset + $this->_getOffset() + $default_offset, $type);
    }



}