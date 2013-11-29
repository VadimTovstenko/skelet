<?
/**
 * @author Anton Tovstenko
 *
 * Class UrlOffsetLanguage
 * ���������� �������� Url-����������
 * ���������� ������� ���� ������
 */
class UrlOffsetLanguage
{


    /**
     * �������� ��������� Url-����������
     * @var int
     */
    private $offset;


    /**
     * ����������� ��������
     * ����������� ����� � �������� ��� �������� �����������
     * @param $config
     * @param $url
     * @return int
     */
    public function init($config,$url) {
                
        if($url->get(0)) {
           
            if(in_array($url->get(0),$config['list'])){
                $this->offset   = 1;
                $language = $url->get(0);
            }
            else {
                $this->offset   = 0;
                $language = $config['default'];
            }  
        } 
        else {
            $language = $config['default'];
        }
        
        Controller::setLanguage($language);
        
        return $this->offset;

    }


    /**
     * ��������� �������� ��������
     * @return int
     */
    public function getOffset() {
        return $this->offset;
    }
    
    
    
    
    
}