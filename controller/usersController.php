<?

class usersController extends Controller
{

    //вместо конструктора
    public function init(){
        $this->view->assign('controller',$this);
        $this->view->assign('languages', Config::get('languages')['list']);

    }

    public function indexAction()
    {

        $this->view->cache->getCache();

        //$this->call(array('controller' => 'index', 'action' => 'edit'));
        //return;

        $model = new Model();
        $profile = $model->profile;

        $this->view->assign('title','Demo Engine');
        $this->view->profiles = $profile->getAllProfiles();

    }

    public function editAction()
    {
        //$this->view->cache->clear();

        $id = $this->getUrlParam(1,'int');
        $this->view->assign( 'title' , 'Edit' );
        $this->view->assign( 'name', $id );

    }

    public function giftAction()
    {
        $request = new Component_Request();
        if ( $request->isAjax() ) {

            $pid = $request->get('pid');

            $model = new Model();
            $gifts = $model->gifts;

            if($gifts->setGift($pid,'lit')){
                echo  'ok!';
                exit;
            }
        }

    }

    public function searchAction()
    {
        $request = new Component_Request();
        if($request->isAjax())
        {
            $pid = $request->get('pid');

            $model = new Model();
            $profile = $model->profile;


            if($data =  $profile->getProfile($pid))
            {
                echo json_encode(array(
                    'image' => $data->avatar,
                    'name' => iconv('cp1251','utf-8',$data->name),
                    'pid'    => $data->id
                ));
            }

        }

        exit;
    }


}
