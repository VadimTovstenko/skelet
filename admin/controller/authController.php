<?
/**
 * Class AuthController
 * ���������� �������� �����������
 */
class AuthController extends Admin_System_Controller
{

	/**
	 * �������������
	 */
	public function init() {
        $this->view->controller = $this;
    }


	/**
	 * ���������������� �� ����� �����������
	 */
	public function indexAction()
    {
        $this->loginAction();
    }


	/**
	 * ������� �����������
	 */
	public function loginAction()
    {
        $request = new Component_Request();

		if( $request->post() )
		{
			$login = $request->post('login', 'string');
			$pass = $request->post('pass', 'string');

			if ( $login && $pass )
			{
				$administrators = new Admin_Model_Administrators();

				if($data = $administrators->getByUserName($login))
				{
					if ( $data->login === $login && $data->pass === md5($pass) ) {

						$this->ident->login($data);

						$this->redirect('/admin');

					} else {
						// ������� ��������� �� ������
						$this->view->error = true;
					}

				} else {
					// ������� ��������� �� ������
					$this->view->error = true;
				}

			} else {
				// ������� ��������� �� ������
				$this->view->error = true;
			}
		}

		// �������� ����� � �����
        $this->view->login = $login;

    }


	/**
	 * ��������������
	 */
	public function logoutAction()
    {
        $this->ident->logout();
        $this->redirect('/admin');
    }

}