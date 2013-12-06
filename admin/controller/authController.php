<?
class AuthController extends Controller
{

    public function init() {
        $this->view->assign('controller',$this);

    }

    public function indexAction()
    {
        $this->loginAction();
    }



    public function loginAction()
    {
        $request = new Component_Request();

        $login = $request->post('login', 'string');
        $pass = $request->post('pass', 'string');

        if ( $login && $pass ) {


            if ($login == 'admin' && $pass == 'admin') {
                $this->ident->login();
                $this->redirect('/admin');
            }

        }

        $this->view->login = $login;

    }


    public function logoutAction()
    {
        $this->ident->logout();
        $this->redirect('/admin');
    }

}