<?

class UsersController extends Controller
{

    //вместо конструктора
    public function init(){
        $this->view->assign('controller',$this);
        $this->view->assign('languages', Config::get('languages')->list);

    }

    public function indexAction()
    {


    }

    public function editAction()
    {
        //$this->view->cache->clear();

        $id = $this->getUrlParam(1,'int');

        if($id == 123)
            Errors::error404();



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

            }
        }

        exit;
    }


    public function magAction()
    {
        $request = new Component_Request();
        if ( $request->isAjax() ) {

            $sid = $request->get('sid');

            $model = new Model();
            $images = $model->images;

            if($images->setGift($sid)){
                echo  'ok!';
            }
        }

        exit;
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


    public function searchMagAction()
    {
        $request = new Component_Request();
        if($request->isAjax())
        {
            $sid = $request->get('sid');

            $model = new Model();
            $images = $model->images;

            if($data =  $images->getImage($sid))
            {
                echo json_encode(array(
                    'image' => $data->src,
                    'sid'    => $data->soc_id
                ));
            }

        }

        exit;
    }

}
