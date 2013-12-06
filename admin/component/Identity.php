<?
class Admin_Component_Identity
{

    public function isAuth()
    {
        if ( Session::getParam('logged')) {
            return true;
        }

        return false;
    }


    public function login()
    {
        Session::setParam('logged', true);
    }


    public function Logout()
    {
        Session::destroy();
    }

}
