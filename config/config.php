<?
    
//Конфигурация

    $config = array(
        
        'db' => array(
            'location'      => "localhost",
            'user'          => "root",
            'pass'          => "",
            'name'          => "test",
            'charset'       => "CP1251",
            'show_error'    => DEBUG_MODE,
        ),
        
        'default_controller'    => 'index',
        'default_action'        => 'index',
        
        'languages'    => array(
                            'status'  => true,
                            'default' => 'ru',
                            'list'    => array (
                                            'ua',
                                            'ru',
                                            'en',
                                         ), 
                        ),
    
    );


     
