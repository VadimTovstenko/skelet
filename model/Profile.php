<?
class Profile extends System_Model
{
    private $_table = 'users_profile';


    public function getAllProfiles() {
        $this->db->query('SELECT * FROM '.$this->_table);
        return $this->db->results();
    }


    public function getProfile($pid) {
        $this->db->query("SELECT * FROM ".$this->_table." WHERE id = '".$pid."'LIMIT 1");
        return $this->db->result();
    }

}