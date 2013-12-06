<?
/**
 * модель подарков пользователя
 * */
class Gifts extends System_Model
{
    private $_table = 'gifts';

    /**
     * проверка наличия подарков у пользователя
     * @return (object) типы подарков или false
     * */
    public function getGifts($pid)
    {
        $query = "SELECT * FROM ".$this->_table." WHERE profile_id = $pid AND status = 1";
        $this->db->query($query);

        if($this->db->num_rows()){
            return $this->db->results();
        }

        return false;
    }



    /**
     * Установка подарка пользователю
     * @return boolean
     * */
    public function setGift($pid,$type)
    {
        $query = "INSERT INTO ".$this->_table." SET profile_id = $pid, type = '$type' ";
        $this->db->query($query);

        if($this->db->affected_rows()){
            return true;
        }

        return false;
    }


    /**
     * Установка статуса подарка пользователя как обработанного
     * @return boolean
     * */
    public function setStatus($id)
    {
        $query = "UPDATE ".$this->_table." SET status = 0 WHERE id = $id ";
        $this->db->query($query);

        if($this->db->affected_rows()){
            return true;
        }

        return false;
    }
}