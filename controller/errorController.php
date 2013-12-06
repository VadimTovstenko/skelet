<?
class ErrorController extends Controller
{

    public function indexAction()
    {

        if ( Errors::isErrors() ) {

            if ( DEBUG_MODE ) {

                foreach( Errors::getAll() as $name => $mess) {
                    echo $mess.'<br/>';
                }

                exit;

            }  else {
                $this->view->setLayout('error');
            }

        }
    }


    public function error404Action()
    {
        $this->view->setLayout('error');
    }

}