<?

class indexController extends Admin_System_Controller
{

    public function init(){
        $this->view->controller = $this;
    }

    public function indexAction()
    {
        $this->view->legend 	= Admin_Widget_Legend::get('�������������� ��������', '����� Lipton Ice Tea','23','qwew');


    }


    public function magAction()
    {
        $this->view->legend = Admin_Widget_Legend::get('�������������� ��������', '�������','23','qwew');

		$model 	= new System_Model();
		$images	= $model->images;
		$this->view->images 	= $images->getWinImages();
    }

}
