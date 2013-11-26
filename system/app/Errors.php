<?
class Errors extends App
{
    private $tbl = 'errors';
    private $errors = array();
    
    public function fix($uid, $file)
    {
        $query = "INSERT INTO ".$this->tbl." SET user_id ='".$uid."', file = '".$file."', date = NOW(), ip ='".$_SERVER['REMOTE_ADDR']."'";
        $this->dbase->query($query);
    }
    
    
    public function add_msg($text)
    {
        $this->errors[] = $text;
    }
    
    public function get_errors()
    {
        return $this->errors;
    }

    
}