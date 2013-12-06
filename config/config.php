<?
    
//Конфигурация

    $config = array(

        'title'  => 'Demo Engine',

        'cache'  => true,

        'db' => array(
            'location'      	=> "localhost",
            'user'   			=> "ani",
            'pass'           	=> "wtVngqxn",
            'name'          	=> "lipton_hash",
            'charset'       	=> "CP1251",
            'show_error'	=> DEBUG_MODE,
            'cache_size'  	=> 33554432
        ),

        
        'default_controller' 				=> 'users',
        'default_action' 					=> 'index',

        'admin_default_controller'   	=> 'index',
        'admin_default_action'       	=> 'index',
        
        'languages'    	=> array(
                            'status'  	=> true,
                            'default' 	=> 'ru',
                            'list'    		=> array (
												'ua',
												'ru',
												'en',
                                        	 ),
                        ),
    
    );


     
