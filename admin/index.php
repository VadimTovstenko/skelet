<?

//��������� ������
session_start();
@ini_set('session.cookie_lifetime', 0);    // 0 - ���� ������� �� ������

define("DEBUG_MODE", true);
define("ROOT", $_SERVER["DOCUMENT_ROOT"]);

//��������� ��������� �� �������
ini_set("display_errors", DEBUG_MODE);

require_once(ROOT."/system/_autoload.php");

//������� ����������
$admin_app = new Admin_System_App();
$admin_app::run();

