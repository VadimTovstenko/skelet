<?

//Запускаем сессию
session_start();
@ini_set('session.cookie_lifetime', 0);    // 0 - пока браузер не закрыт

define("DEBUG_MODE", true);
define("ROOT", $_SERVER["DOCUMENT_ROOT"]);

//Настройка сообщений об ошибках
ini_set("display_errors", DEBUG_MODE);

// Настройка относительных путей
set_include_path(implode(PATH_SEPARATOR, array(
    ROOT.'/library',
    get_include_path()
)));

require_once(ROOT."/admin/system/_autoload.php");

//Создаем приложение
$app = new Admin();
$app::run();

