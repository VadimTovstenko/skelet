<?      
// Засекаем время 
    $time_start = microtime(true);
    
//Запускаем сессию 
    //session_set_cookie_params(1209600);
    session_start();     
    //@ini_set('session.gc_maxlifetime', 86400); // 86400 = 24 часа
    //@ini_set('session.cookie_lifetime', 0);    // 0 - пока браузер не закрыт

    define("DEBUG_MODE", true);
    define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
    
//Настройка сообщений об ошибках  
    ini_set("display_errors", DEBUG_MODE);

// Настройка относительных путей
    set_include_path(implode(PATH_SEPARATOR, array(
        ROOT.'/library',
        get_include_path()
    )));

    require_once(ROOT."/system/autoload.php");

//Создаем приложение
    $app = new App();
    $app::run();

