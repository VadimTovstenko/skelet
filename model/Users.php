<?
class Users extends System_Model
{
    public  $_table = 'users_data';
    public  $social;
    public  $user_id;
    public  $avatar;
    

    public function getAllUsers() {
        $this->db->query('SELECT * FROM '.$this->_table);
        return $this->db->results();
    }
    

    
    
}
