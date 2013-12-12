<?
class Admin_Component_Identity
{

    public function isAuth()
    {
        if ( System_Session::getParam('logged')) {
            return true;
        }

        return false;
    }


    public function login( $data )
    {
		System_Session::setParam('logged', true);
		System_Session::setParam('admin_id', $data->id);
		System_Session::setParam('admin_login', $data->login);
    }


	public function getId()
	{
		return System_Session::getParam('admin_id');
	}

	public function getLogin()
	{
		return System_Session::getParam('admin_login');
	}

    public function Logout()
    {
		System_Session::destroy();
    }


	public function setAccess($params)
	{
		foreach ($params as $name => $access) {
			System_Session::setParam($name, $access);
		}
	}



	public function checkAccess()
	{
		$controllerName 		= Admin_System_App::getControllerName();
		$actionName 			= Admin_System_App::setActionName();
		$controllerAccess 	= System_Session::getParam($controllerName);
		$actionAccess			= System_Session::getParam($actionName);

		if ( $controllerAccess !== null && $controllerAccess === false  ) {
			System_Errors::error403();
		}

		if ( $actionAccess !== null && $actionAccess === false ) {
			System_Errors::error403();
		}

		return true;
	}
}
