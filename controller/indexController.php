<?

class indexController extends Controller
{    

    //������ ������������
    public function init(){
        $this->view->assign('controller',$this);
    }
    
    public function indexAction()
    {

    }
    
    public function editAction()
    {

    }
    
    public function ajaxAction()
    {
        $request = new Component_Request();
        if($request->isAjax()){
            echo 'clalled by Ajax';
            exit; 
        }
        
    }
    

}
