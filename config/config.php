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

        
        'default_controller' 				=> 'players',
        'default_action' 					=> 'index',

        'input_max_len'					=> 30,


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


     
