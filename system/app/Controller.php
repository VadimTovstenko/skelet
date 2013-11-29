<?
/**
 * @author Anton Tovstenko
 *
 * Class Controller
 * �����-����� ��� ����������� ������� ����������,
 * � �������� ����� �������� ������-���������� - ����������� ��������
 */
class Controller
{


    /**
     * ��������� ������ View
     * �������� ������ �� ���������� � ������ �������������
     * �������� ����� �� ����������� ����������� ���� ���������:
     *      1. $this->view->assign('varName', $varValue);
     *      2. $this->view->varName = $varValue;
     * ��������� ������������ ��������
     * @var View
     */
    public $view;



    /**
     * ����������� ���������� ������ �������� �������� ����� ������
     * @var
     */
    private  static $lang;



    public function __construct() {

        $this->view              = new View();
        $this->view->cache   = new Cache();

        if ( isset( $_GET['clear_cache'] ) ) {
            $this->view->cache->clear();
        }

    }


    /**
     * ������������ �������� �����.
     * ���������� � ������� ������������� �������� Url-���������� � ������ UrlOffsetLanguage
     * @param $lang
     */
    public static function setLanguage($lang){
        self::$lang = $lang;
    }


    /**
     * ��������� �������� �����
     * @return mixed
     */
    public function getLanguage(){
        return self::$lang;
    }



    /**
     * ���������� ����������� Url-������ � ������
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
     * ��������������� �� ��������� �����
     * @param $url
     */
    public function redirect($url)
    {
        header('location:'.$url);
        exit;
    }


    /**
     * �������, ���������� ��������� �������� �����������.
     * !!! ��������� �������� ������� �������� �������� �����������
     * @param array $params
     */
    public function call(array $params)
    {
        App::init($params);
        App::run();
    }


    /**
     * ����������� �������� Url-���������� � ����� � ����������� ��������� ����� ������
     * @return int
     */
    private  function _getOffset()
    {
        return App::$offset;
    }


    /**
     * ��������� ���������� �� �������� ������
     * ������ ���������� ����� Action, � ����
     * @param $urlOffset
     * @param null $type
     * @return bool
     */
    public function getUrlParam( $urlOffset, $type = null )
    {
        /**
         *�������� ��� /controller/action
         * @var $default_offset int */
        $default_offset = 2;

        $url = new Url();
        return $url->get( $urlOffset + $this->_getOffset() + $default_offset, $type);
    }



    /**
     * ���������� ������ �����������
     * �������� ���������� � ��
     */
    public function __destruct()
    {
        Component_Db::getInstance()->close();
    }


}