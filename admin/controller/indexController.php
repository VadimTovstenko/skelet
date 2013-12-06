<?

class indexController extends Controller
{

    public function init(){
        $this->view->controller = $this;
    }

    public function indexAction()
    {
        $this->view->legend 	= Admin_Widget_Legend::get('Редактирование подарков', 'Ящики Lipton Ice Tea','23','qwew');


    }


    public function magAction()
    {
        $this->view->legend = Admin_Widget_Legend::get('Редактирование подарков', 'Магниты','23','qwew');

		$model 	= new Model();
		$images	= $model->images;
		$this->view->images 	= $images->getWinImages();
    }

}
