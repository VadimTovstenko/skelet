<?

//��������� ������
session_start();
@ini_set('session.cookie_lifetime', 0);    // 0 - ���� ������� �� ������

define("DEBUG_MODE", true);
define("ROOT", $_SERVER["DOCUMENT_ROOT"]);

//��������� ��������� �� �������
ini_set("display_errors", DEBUG_MODE);

// ��������� ������������� �����
set_include_path(implode(PATH_SEPARATOR, array(
    ROOT.'/library',
    get_include_path()
)));

require_once(ROOT."/admin/system/_autoload.php");

//������� ����������
$app = new Admin();
$app::run();

