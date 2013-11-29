<?

class indexController extends Controller
{    

    //вместо конструктора
    public function init(){
        $this->view->assign('controller',$this);
    }
    
    public function indexAction()
    {

        //$this->call(array('controller' => 'index', 'action' => 'edit'));
        //return;

        $model = new Model();
        $user  = $model->users;
         
        $this->view->assign('title','Demo Engine');
        $this->view->assign('users',$user->getAllUsers());
    }
    
    public function editAction()
    {

        $model = new Model();
         
        $this->view->assign('title','Edit');
        $this->view->assign('action','edit');
        $this->view->assign('lang',$this->language);

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
