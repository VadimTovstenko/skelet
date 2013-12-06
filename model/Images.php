<?
class Images extends System_Model
{
    private $_table = 'images';

    public function getImage($id) {
        $this->db->query("SELECT * FROM ".$this->_table." WHERE soc_id = '".$id."'LIMIT 1");
        return $this->db->result();
    }


    public function setGift($sid)
    {
        $this->db->query( "UPDATE ".$this->_table." SET win = 1 WHERE soc_id = '$sid' ");

        if($this->db->affected_rows()){
            return true;
        }

        return false;
    }


	public function getWinImages()
	{
		$this->db->query('SELECT looks+(SELECT COUNT(id) as count FROM `likes` WHERE image_id = images.soc_id ) as rate, soc_id, src  FROM images WHERE moderated != -1 AND win = 0 ORDER BY rate  DESC LIMIT 20');
		return $this->db->results();
	}


}
