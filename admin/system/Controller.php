<?
/**
 * @author Anton Tovstenko
 *
 * Class Controller
 * Супер-класс для определения базовых параметров,
 * с которыми будут работать классы-наследники - контроллеры действий
 */
class Admin_System_Controller
{


    /**
     * Экземпляр класса View
     * Передает данные из контролера в шаблон представления
     * Передача даных из контроллера реализована думя способами:
     *      1. $this->view->assign('varName', $varValue);
     *      2. $this->view->varName = $varValue;
     * Управляет кешировашием страницы
     * @var View
     */
    public $view;



    /**
     * Статическая переменная хранит значение текущего язика локали
     * @var
     */
    private  static $lang;


    public $ident;


    public function __construct() {

        $this->view   	= new Admin_System_View();
        $this->ident 	= new Admin_Component_Identity();
        $url    			= new System_Url();

        if ( !$this->ident->isAuth() && $url->get(1) != 'login') {
            $this->redirect('/admin/auth/login');
        }

    }



    /**
     * Установление текущего язика.
     * Вызивается в процесе инициализации смещения Url-параметров в классе UrlOffsetLanguage
     * @param $lang
     */
    public static function setLanguage($lang){
        self::$lang = $lang;
    }


    /**
     * Получение текущего язика
     * @return mixed
     */
    public function getLanguage(){
        return self::$lang;
    }



    /**
     * Построение правильного Url-адреса с учетом
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
     * Перенаправление на указанный адрес
     * @param $url
     */
    public function redirect($url)
    {
        header('location:'.$url);
        exit;
    }


    /**
     * Функция, вызывающая указанное действие контроллера.
     * !!! Запрещено вызивать текущее действие текущего контроллера
     * @param array $params
     */
    public function call(array $params)
    {
        Admin::init($params);
        Admin::run();
    }


    /**
     * Определение смещения Url-параметров в связи с добавлением параметра язика локали
     * @return int
     */
    private  function _getOffset()
    {
        return Admin::$offset;
    }


    /**
     * Получение параметров из адресной строки
     * отсчет начинается после Action, с нуля
     * @param $urlOffset
     * @param null $type
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



    /**
     * Завершение работы контроллера
     * Закрытие соединения с БД
     */
    public function __destruct()
    {
        Component_Db::getInstance()->close();
    }


}