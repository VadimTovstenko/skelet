<?
    
//Конфигурация

    $config = array(

        'title' 		=> 'Casino',

        'cache'  	=> false,

        'db' 		=> array(
							'location'      	=> "localhost",
							'user'   			=> "root",
							'pass'           	=> "",
							'name'          	=> "casino",
							'charset'       	=> "CP1251",
							'show_error'	=> DEBUG_MODE,
        ),

        
        'default_controller' 				=> 'users',
        'default_action' 					=> 'index',

        'admin_default_controller'   	=> 'players',
        'admin_default_action'       	=> 'index',
        
        'languages'    	=> array(
										'status'  	=> false,
										'default' 	=> 'ru',
										'list'    		=> array (
															'ua',
															'ru',
															'en',
														),
		),

		'access' 	=> array(
								// roles
								'admin' 	=> array(

								),

								'moder'	=> array(

								),
		)
    
    );


     
