<?
class Images extends App
{
    private $_table = 'images';
    private $_valid_formats = array("jpg", "JPG", "png", "PNG", "jpeg", "JPEG");
    private $_mb = 5;  
    
    public  $pathBig   = "/files/img_o/"; //каталог с оригинальными картинками 
    public  $pathSmall = "/files/img_s/"; //каталог с уменьшенными картинками
    public  $pathCut   = '/files/cutted/';//катклог с обтрезанными фотографиями  
    public  $height;
    
    /**
     * Добавление фотографии в БД
     * вовращает ID вставленой записи
     * */
    public function add($user_id,$name,$soc_id,$src,$height)
    {
        $query = "INSERT INTO ".$this->_table." SET user_id='".$user_id."', soc_id = '".$soc_id."', name ='".$name."', src ='".$src."', height = $height ";
        $this->dbase->query($query);
        
        if($id = $this->dbase->insert_id())
            return $id;
        return false;
    }
    
    
    
    /**
     * Получение фотографии пользователя
     * */
    public function getUserImage($user_id,$soc_id)
    {       
        $query = "SELECT * FROM ".$this->_table." WHERE user_id ='".$user_id."' AND  soc_id ='".$soc_id."' LIMIT 1";
        $res = mysql_query($query);
        if(mysql_num_rows($res))
            return true;
        return false;
    }
    
    
    
    /**
     * Получение всех фотографий пользователя
     * */
    public function getUserImages($ids)
    {       
        $query = "SELECT * FROM ".$this->_table." WHERE user_id IN(".$ids.") ORDER BY date DESC";
        $this->dbase->query($query);
        
        if($this->dbase->num_rows())
            return $this->dbase->results();
        return false;  
    }
    
    
    /**
     * Получение Полной информации о фотографиях пользователя
     * */
    public function getImages($start=0,$quant=10)
    {       
        $query = "SELECT 
            id, soc_id, user_id, name, date, likes, looks, win, src, height, gift,
            (SELECT name FROM users_profile WHERE id = (SELECT profile_id FROM users_data WHERE user_id = ".$this->_table.".user_id)) as user_name
           	FROM ".$this->_table." WHERE moderated != '-1' ORDER BY date DESC LIMIT $start,$quant ";
        
        $this->dbase->query($query);
        
        if($this->dbase->num_rows())
            return $this->dbase->results();
        return false;  
    }
    
    
    /**
     * Установка модерации к фотографии
     * */
    public function setModerated($id)
    {
        $query = "UPDATE ".$this->_table." SET 	moderated = 1 WHERE id =".$id." LIMIT 1";
        $this->dbase->query($query);
        
        if($this->dbase->affected_rows())
            return true;
        return false;
    }
    
    
    
    /**
     * Установка выигрышной фотографии
     * */
    public function set_win($id)
    {
        $query = "UPDATE ".$this->_table." SET 	win = 1 WHERE id =".$id." LIMIT 1";
        $this->dbase->query($query);
        
        if($this->dbase->affected_rows())
            return true;
        return false;
    }
    
    
    
    /**
     * Получение выигрышных фотографий пользователя
     * */
    public function get_win($ids)
    {
        $query = "SELECT * FROM ".$this->_table." WHERE user_id IN(".$ids.") AND win = 1";
        $this->dbase->query($query);
        
        if($this->dbase->num_rows())
            return $this->dbase->results();
        return false;
    }
    
    
    
     /**
     * Получение выигрышных фотографий пользователя по ID
     * */
    public function get_win_by_id($id)
    {
        $query = "SELECT * FROM ".$this->_table." WHERE id = '$id' AND win = 1 LIMIT 1";
        $this->dbase->query($query);
        
        if($this->dbase->num_rows())
            return $this->dbase->result();
        return false;
    }
    
    
    /**
     * Отмечаем выигрышную фотографию как обработанную
     * win = 2 - обработанная фотография не принимает луки ы лайки
     * */
    public function complete_win($id)
    {
        $query = "UPDATE ".$this->_table." SET 	win = 2 WHERE id =".$id." LIMIT 1";
        $this->dbase->query($query);
        
        if($this->dbase->affected_rows())
            return true;
        return false;
    }
    
    
    
    /**
     * Баним фотографию
     * moderated = -1 чтобы не подтянулась снова из соц. сети
     * */
    public function delete($id)
    {      
        $query = "UPDATE ".$this->_table." SET 	moderated = -1 WHERE soc_id = '$id' ";
        $this->dbase->query($query);
        
        if($this->dbase->affected_rows())
            return true;
        return false;
    }
    
    
    
    /**
     * Получение источника фотографии
     * */
    public function get_source($imgPath)
    {
        if(!file_exists($imgPath))
            return false;
            
        $params = getimagesize($imgPath);

        switch ( $params[2] ) {
          case 1: $source = imagecreatefromgif($imgPath); break;
          case 2: $source = imagecreatefromjpeg($imgPath); break;
          case 3: $source = imagecreatefrompng($imgPath); break;
        }
        return $source;
    }
    
    
    /**
     * Изменение размера картинки
     * @return $resource
     * */
    public function resize($pathBig,$max_width = 235)
    {     
        $params = getimagesize($pathBig);
        switch ( $params[2] ) {
          case 1: $source = imagecreatefromgif($pathBig); break;
          case 2: $source = imagecreatefromjpeg($pathBig); break;
          case 3: $source = imagecreatefrompng($pathBig); break;
        }
        
        $k = $params[0]/$max_width;
        
        if ( $params[0] > $max_width ) 
        {
            $resource_width  = floor($params[0]/$k);
            $resource_height = floor($params[1]/$k);   
            
            $resource = imagecreatetruecolor($resource_width, $resource_height);
            
            $this->height = $resource_height;
              
            // изменение размера и копирование полученного на «подкладку»
            imagecopyresampled($resource, $source, 0, 0, 0, 0,$resource_width, $resource_height, $params[0], $params[1]);
        }
        else {
            
            // если изменять размер не надо просто присваиваем переменной
            // $resource идентификатор оригинальной картинки
            $this->height = floor($params[1]*$k); 
            $resource = $source;  
        }
     
        return $resource;
    }
    
    
    /**
     * проверка на валидность формата
     * */
    public function is_valid($ext)
    {
        return in_array($ext,$this->_valid_formats);
    }
    
    
    /**
     * получение допустимого размера картинки 
     * */
    public function get_size()
    {
        return 1024*1024*$this->_mb;
    }
    
    /**
     * получение разрешения картинки 
     * */
    public function get_resolution($imgPath)
    {
        if(!file_exists($imgPath))
            return false;
            
        $params = getimagesize($imgPath);
        
        return array('width' => $params[0], 'height' => $params[1]);
    }
    
    
    /**
     * установка обрезаной текущей фотографии 
     * */
    public function set_current($imgPath, $name, $id=null)
    {
        if(!file_exists($imgPath))
            return false;
            
        $_SESSION['current_cut_img']['path'] = $imgPath;
        $_SESSION['current_cut_img']['name'] = $name;
    }
    
    
    
    /**
     * получение пути файла текущей обрезаной фотографии 
     * возвращает объект
     * */
    public function get_current()
    {       
        if(isset($_SESSION['current_cut_img']))    
            return $this->_toObject(array(
                                        'path' => $_SESSION['current_cut_img']['path'],
                                        'name' => $_SESSION['current_cut_img']['name']
                                        ));
        return false;
    }
    
    
    /**
     * Удаление  пути файла текущей обрезаной фотографии 
     * */
    public function del_current()
    {
        unset($_SESSION['current_cut_img']);
    }
    
    
    
    /**
     * Добавление водяного знака
     * */
    public function add_watermak($imgPath,$watermakPath)
    {
        if(!file_exists($imgPath))
            return false;
            
        $watermark = new Watermark();

        $options = array(
        	'watermark_position' => 'top_right',
        	'watermark_type' => 'image',
        	'vertically' => 32,
        	'horizontally' => -32,
        );
        
        $imageResource = $this->get_source($imgPath);
        
        try {
        	
        	$image = $watermark->init($imageResource, $options, $watermakPath);
        	
            if(imagejpeg($image, $imgPath))
                return true;
        	return false;
            
        } catch (Exception $e) {
        			
        	$e->getMessage();
            return false;	
        }
        return false;
    }
    
    /**
     * Создает уникальное имя
     * */
    public function generate_name($user_id,$social)
    {    
        return time()."-".$social."-".rand(100,999)."-".$user_id.".jpg"; 
    }
    
    
    /**
     * Получаем лайки
     * */
    private function get_likes($id)
    {
        $query = "SELECT * FROM likes WHERE image_id = '".$id."' AND profile_id = ".$this->users->get_prof_id();
        $this->dbase->query($query);
        
        if($this->dbase->num_rows())
            return false;
        return true;
    }
    
    
    /**
     * Получаем лайки пользователя
     * */
    public function get_user_likes()
    {
        $query = "SELECT * FROM likes WHERE profile_id = ".$this->users->get_prof_id();
        $this->dbase->query($query);
        
        if($this->dbase->num_rows())
            return $this->dbase->results();
        return false;
    }
    
    
    /**
     * Добавляем лайки
     * */
    public function add_like($id)
    {
        if(!$this->get_likes($id))
            return false;
        
        $query = "INSERT INTO likes SET image_id = '".$id."', profile_id = ".$this->users->get_prof_id();  
        $this->dbase->query($query);
        
        if($this->dbase->affected_rows())
            return true;
        return false;
    }
    
    
    /**
     * Подсчиет просмотров фотографии
     * */
    public function count_looks($id)
    {
        $query = "SELECT COUNT(*) as count FROM looks WHERE image_id = '".$id."'";
        $this->dbase->query($query);
        
        if($this->dbase->num_rows())
            return $this->dbase->result()->count;
        return 0;
    }
     
    
    /**
     * Получаем просмотры пользователя
     * */
    private function get_looks($id)
    {
        $query = "SELECT * FROM looks WHERE image_id = '".$id."' AND profile_id = ".$this->users->get_prof_id();
        $this->dbase->query($query);
        
        if($this->dbase->num_rows())
            return false;
        return true;
    }
    
    
    /**
     * Добавляем просмотры
     * */
    public function add_look($id)
    {
        if(!$this->get_looks($id))
            return false;
        
        $query = "INSERT INTO looks SET image_id = '".$id."', profile_id = ".$this->users->get_prof_id();  
        $this->dbase->query($query);
        
        if($this->dbase->affected_rows())
        {
             $count = $this->count_looks($id);
             $query = "UPDATE ".$this->_table." SET looks = ".$count." WHERE soc_id ='".$id."'";
             $this->dbase->query($query);
             
             return true;
        }
        return false;
    }
    
    
    /**
     * Установка подарочной картинки из шером
     * */
    public function setGiftImage()
    {
        $query   = "SELECT MAX(id) as max_id FROM ".$this->_table;
        $this->dbase->query($query);
        $max_id  = $this->dbase->result()->max_id;
        
        $rand_id = mt_rand(1,$max_id);
        
        $query = "UPDATE ".$this->_table." SET gift = 0";
        $this->dbase->query($query);
        $query = "UPDATE ".$this->_table." SET gift = 1 WHERE id = $rand_id";
        $this->dbase->query($query);
        
        if($this->dbase->affected_rows()){
            return true;
        }
        return false;
    }
    

    
}










