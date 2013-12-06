<?

//Запускаем сессию
session_start();
@ini_set('session.cookie_lifetime', 0);    // 0 - пока браузер не закрыт

define("DEBUG_MODE", true);
define("ROOT", $_SERVER["DOCUMENT_ROOT"]);

//Настройка сообщений об ошибках
ini_set("display_errors", DEBUG_MODE);

require_once(ROOT."/system/_autoload.php");

//Создаем приложение
$admin_app = new Admin_System_App();
$admin_app::run();

