<?      
// �������� ����� 
    $time_start = microtime(true);
    
//��������� ������ 
    //session_set_cookie_params(1209600);
    session_start();     
    //@ini_set('session.gc_maxlifetime', 86400); // 86400 = 24 ����
    //@ini_set('session.cookie_lifetime', 0);    // 0 - ���� ������� �� ������

    define("DEBUG_MODE", true);
    define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
    
//��������� ��������� �� �������  
    ini_set("display_errors", DEBUG_MODE);

// ��������� ������������� �����
    set_include_path(implode(PATH_SEPARATOR, array(
        ROOT.'/library',
        get_include_path()
    )));

    require_once(ROOT."/system/autoload.php");

//������� ����������
    $app = new App();
    $app::run();

