<?
class SettingsController extends Admin_System_Controller
{

	public function init(){
		$this->ident->checkAccess();
		$this->view->controller = $this;
	}

	public function indexAction()
	{

	}


	public function testAction()
	{

	}

}