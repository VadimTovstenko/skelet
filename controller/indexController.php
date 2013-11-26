<?

class indexController extends Controller
{    
    private $init;
    
    //вместо конструктора
    public function init(){
        $this->init = 'init';
    }
    
    public function indexAction()
    {
        //App::init(array('controller' => 'index', 'action' => 'edit'));
        //App::run();
        //return;
        
        $sql   = new Component_Sql();
        
        $user  = $this->model->users;
         
        $this->view->assign('title','Trololo');
        $this->view->assign('name',$user->test());
        $this->view->assign('url',$this->createUrl(array('index','edit')));     
    }
    
    public function editAction()
    {
        $name = 'Anton';
        
        $model = new Model();
        $user  = $this->model->users;  
        //$db    = $this->model->db;
         
        //$db->query('SELECT NOW() as now');
        
        $this->view->tpl('index');
         
        $this->view->assign('title','Edit');
        $this->view->assign('action','edit');
       // $this->view->assign('name',$db->result()->now);
        $this->view->assign('lang',$this->language);
        $this->view->assign('url',$this->createUrl(array('index','edit')));
        
        //$this->view->setLayout('test');
    }
    
    public function ajaxAction()
    {
        if($this->request->isAjax()){
            echo 'adasdasds';
            exit; 
        }
        
    }
    

}
