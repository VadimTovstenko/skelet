<?
    
//Конфигурация приложения
    $config = array(

		// тайтл поумолчанию
        'title' 		=> 'Casino',

		// конфигурация подключения к БД
        'db' 		=> array(
							'location'      	=> "localhost",
							'user'   			=> "root",
							'pass'           	=> "",
							'name'          	=> "casino",
							'charset'       	=> "CP1251",
							'show_error'	=> DEBUG_MODE,
        ),

        // контроллер, который будет вызван первым
        'default_controller' 				=> 'players',

		// действие, вызиваемое по умолчанию
        'default_action' 					=> 'index',

		// максимальная длинна полей формы
        'input_max_len'					=> 30,

		// кеширование
		'cache'  	=> false,

		// многоязичность
		'languages'    	=> array(
										'status'  	=> false,
										'default' 	=> 'ru',
										'list'    		=> array (
															'ua',
															'ru',
															'en',
														),
		),


		// правила доступа
		'access' 	=> array(
								// roles
								'admin' 	=> array(

								),

								'moder'	=> array(

								),
		)
    
    );


     
