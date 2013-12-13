<?
//Запускаем сессию
    session_start();     

    define("DEBUG_MODE", false);
    define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
    
//Настройка сообщений об ошибках  
    ini_set("display_errors", DEBUG_MODE);

    require_once(ROOT."/system/_autoload.php");

//Создаем приложение
    $app = new System_App();
    $app::run();

