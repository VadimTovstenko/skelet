<?
class Users
{
    private $table = 'users_data';
    public  $social;
    public  $user_id;
    public  $avatar;
    
    private $db;
    
    public function __construct()
    {
       $this->db = new Component_Db();
    }
    
    
    public function test()
    {
        $this->db->query('SELECT NOW() as now'); 
        return $this->db->result()->now;
    }
    
    

    
    
}