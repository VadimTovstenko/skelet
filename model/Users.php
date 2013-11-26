<?

class Users
{
    private $table = 'users_data';
    private $tbl_p = 'users_profile';
    public  $social;
    public  $user_id;
    public  $avatar;
    
    private $db;
    
    public function __construct()
    {
       $model = new Model();
       $this->db = $model->db;
    }
    
    
    public function test()
    {
        $this->db->query('SELECT NOW() as now'); 
        return $this->db->result()->now;
    }
    
    

    
    
}