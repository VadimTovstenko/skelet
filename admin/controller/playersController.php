<?

class playersController extends Admin_System_Controller
{

	/**
	 * »нициализаци€
	 */
	public function init(){
        $this->view->controller = $this;
		$request = new Component_Request();

		if( $request->post('event') )
		{
			$this->event( $request->post('event') );
		}
}

    public function indexAction()
    {
		$players = new Admin_Model_Players();

		$this->view->players 	= $players->getAll();

    }


	/**
	 * ƒобавление игрока
	 */
	public function addAction()
    {
		$request = new Component_Request();

		if ( $request->post() )
		{
			$this->validProcess($request);
		}

		$this->view->context 	= 'add';
		$this->view->admin_id 	= $this->ident->getId();
		$this->view->legend 		= Admin_Widget_Legend::getEditLegend('ƒобавление нового игрока','New player');
		$this->view->tpl('form');
    }


	/**
	 * –едактирование данных игрока
	 */
	public function editAction()
	{
		$request 	= new Component_Request();

		if ( $request->post() )
		{
			$this->validProcess( $request );
		}

		$url			= new System_Url();
		$player_id 	= $url->get(2,'int');

		$player 		= new Admin_Model_Players();
		$data 		= $player->getById($player_id);

		// передаем все данные в шаблон представлени€
		foreach( $data as $key => $val ) {
			$this->view->$key = $val;
		}

		$this->view->context 	= 'edit';
		$this->view->player_id	= $player_id;
		$this->view->admin_id 	= $data->admin_id;
		$this->view->legend 		= Admin_Widget_Legend::getEditLegend('–едактирование игрока','New player');
		$this->view->tpl('form');
	}


	public function deleteAction()
	{
		$url			= new System_Url();
		$player_id 	= $url->get(2,'int');

		$player 		= new Admin_Model_Players();

		if( $player->delete( $player_id ) ) {
			$this->redirect('/admin/players');
		}
	}

	/**
	 * ѕроцесс валидации данных формы
	 * @param $request
	 */
	private function validProcess( $request )
	{
		$data = array(
			'username' 	=> $request->post('username','string'),
			'first_name' 	=> $request->post('first_name','string'),
			'last_name' 	=> $request->post('last_name','string'),
			'birth_date' 	=> $request->post('birth_date','string'),
			'email' 			=> $request->post('email'),
			'admin_id'		=> $request->post('admin_id','integer')
		);

		//  онтекст. –едактирование или добавление
		$context 	= $request->post('context');
		$player 		= new Admin_Model_Players();
		$validator 	= new Admin_Component_Validator();

		if( $validator->is_valid($data) )
		{
			$playerData = $validator->getData();

			//используем во врем€ редактировани€
			$playerData['player_id'] =  $request->post('player_id','integer');

			// провер€ем наличие имени пользовател€
			if( $player->getByName( $playerData['username'] && $context != 'edit' ) ) {
				$this->view->errors = array('username' => true);
			}

			// провер€ем Email на валидность
			if (!$validator->checkEmail( $playerData['email'] )) {
				$this->view->errors = array('email' => true);
			}

			// усли вс€ валидаци€ прошла, сохраним данные
			if(!$this->view->errors)
			{
				if( $player->$context( $playerData ) )
				{
					$this->redirect('/admin/players');
				}
			}

		} else {
			$this->view->errors = array('empty' => true);
		}

		// передаем все данные в шаблон представлени€
		foreach( $data as $key => $val ) {
			$this->view->$key = $val;
		}
	}


	/**
	 * ѕроверка наличи€ имени игрока
	 * Ajax
	 */
	public function checkloginAction()
	{
		$request = new Component_Request();

		if( $request->isAjax() )
		{
			$username 	= $request->post('username');
			$player 		 	= new Admin_Model_Players();

			if( $player->getByName( $username ) )
			{
				echo json_encode( array(
					'match' => true
				) );

			} else {
				echo json_encode( array(
					'match' => false
				) );
			}


		}

		exit;
	}


	private function event($event)
	{
		$request 	= new Component_Request();
		$player		= new Admin_Model_Players();

		if( $items 	= $request->post('check') )
		{
			$ids = '';
			foreach( $items as $id)
			{
				$ids .= $id.", ";
			}
			$ids = substr($ids, 0, -2);

			if($event == 'delete') 	{
				$player->deleteByIds($ids);
			}

		}
		return true;
	}

}
