<?
/**
 * Class AuthController
 * Контроллер процесса авторизации
 */
class AuthController extends Admin_System_Controller
{

	/**
	 * Инициализация
	 */
	public function init() {
        $this->view->controller = $this;
    }


	/**
	 * Преренаправление на форму авторизации
	 */
	public function indexAction()
    {
        $this->loginAction();
    }


	/**
	 * Прлцесс авторизации
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
						// выводим сообщение об ошибке
						$this->view->error = true;
					}

				} else {
					// выводим сообщение об ошибке
					$this->view->error = true;
				}

			} else {
				// выводим сообщение об ошибке
				$this->view->error = true;
			}
		}

		// передаем логин в форму
        $this->view->login = $login;

    }


	/**
	 * Разлогинивание
	 */
	public function logoutAction()
    {
        $this->ident->logout();
        $this->redirect('/admin');
    }

}