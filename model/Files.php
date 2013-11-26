<?
class Files extends App
{
    public $unik_name;                      // новое им€ файла
    public $pathBig   = "/files/img_o/"; // каталог с оригинальными картинками 
    public $pathSmall = "/files/img_s/"; // каталог с уменьшенными картинками 
    public $mb = 2;              
    

    
    public function get_name()
    {
        return $this->unik_name;
    }
    
    public function upload($fileName)
    {
        if(!isset($_FILES[$fileName])) return false;
        
        $name = $_FILES[$fileName]['name']; 
        $size = $_FILES[$fileName]['size'];

        if(!$name) return false;
        
        list($txt,$ext) = explode(".", $name);      // разбиваем на им€ и формат
        
        if(in_array($ext,$this->valid_formats))     // смотрим формат такой как мы разрешили?!
        {
            if($size < (1024*1024*$this->mb))       // ќграничиваем размер файла 
            {
                $user_id = $this->users->user_id;

                $this->unik_name = $user_id."-".time().".jpg"; // задаем уникальное им€ файлу
                $tmp = $_FILES[$fileName]['tmp_name'];
                
                $imgPathBig   = $_SERVER["DOCUMENT_ROOT"].$this->pathBig.$this->unik_name;
                $imgPathSmall = $_SERVER["DOCUMENT_ROOT"].$this->pathSmall.$this->unik_name;
                
                if(move_uploaded_file($tmp, $imgPathBig)) // переносим файл с tmp в наш каталог
                { 
                    $params = getimagesize($imgPathBig);

                    switch ( $params[2] ) {
                      case 1: $source = imagecreatefromgif($imgPathBig); break;
                      case 2: $source = imagecreatefromjpeg($imgPathBig); break;
                      case 3: $source = imagecreatefrompng($imgPathBig); break;
                    }
                    
                    // ѕересохр€н€ем картинку дл€ безопасности 
                    unlink($imgPathBig);
                    if(imagejpeg($source, $imgPathBig))
                    {
                        //$this->add_watermak($imgPathBig);
                        $response['status'] = true;
                        $response['image'] = $this->pathBig.$this->unik_name;
                    }     
                          
                }
                else
                {
                    $response['status'] = false;
                    $response['msg'] = 'ѕомилка завантаженн€ файлу!';
                }
            }
            else 
            {
                $response['status'] = false;
                $response['msg'] = '–озм≥р файлу не повинен перевищувати '.$this->mb.'Mb!';
            }
        }
        else 
        {
            // записываем нарушител€ 
            $this->errors->fix($this->users->user_id,$name);
            
            $response['status'] = false;
            $response['msg'] = 'Ќев≥рний формат файла!';
        }
        
        $response['msg'] = iconv('cp1251','utf8',$response['msg']);
        return json_encode($response);
    }
    
    
    private function img_resize($imgPathBig,$imgPathSmall)
    {
        $params = getimagesize($imgPathBig);

        switch ( $params[2] ) {
          case 1: $source = imagecreatefromgif($imgPathBig); break;
          case 2: $source = imagecreatefromjpeg($imgPathBig); break;
          case 3: $source = imagecreatefrompng($imgPathBig); break;
        }
        
        // максимально допустимый размер
        // (по ширине/высоте) уменьшенной картинки
        $max_size = 1024;
        // если ширина или высота оригинальной картинки
        // больше ограничени€ производим вычислени€
        if ( $params[0]>$max_size || $params[1]>$max_size ) 
        {
            // выбираем большее: ширины или высота
            // оригинальной картинки
            if ( $params[0]>$params[1] ) $this->size = $params[0]; # ширина
            else $this->size = $params[1]; # высота
            
            // вычисл€м ширину и высоту уменьшенной картинки
            $k = $params[0]/200;
            $resource_width  = floor($params[0]/$k);
            $resource_height = floor($params[1]/$k);
            
            # создание Ђподкладкиї
            $resource = imagecreatetruecolor($resource_width, $resource_height);
              
            # изменение размера и копирование полученного на Ђподкладкуї
            imagecopyresampled($resource, $source, 0, 0, 0, 0,$resource_width, $resource_height, $params[0], $params[1]);
        }
        # если измен€ть размер не надо просто присваиваем переменной
        # $resource идентификатор оригинальной картинки
        else 
            $resource = $source;

        # выводит картинку
        if(imagejpeg($resource, $imgPathSmall))
        {
            $response['status'] = true;
            $response['image'] = $this->pathBig.$this->unik_name;
        }     
    }
    
    
    private function add_watermak($img_path)
    {
        $watermark = new Watermark();

        $options = array(
        	'watermark_position' => 'top_right',
        	'watermark_type' => 'image',
        	'vertically' => 20,
        	'horizontally' => -20,
        );
        
        list($width, $height, $type, $attr) = getimagesize( $img_path );
        			
        	$filetype = image_type_to_extension( $type, false );
        	
            if( $filetype == 'png' )  $imageResource = imagecreatefrompng( $img_path );
            if( $filetype == 'jpeg' ) $imageResource = imagecreatefromjpeg( $img_path );
        
        try{
        	
        	$image = $watermark->init( $imageResource, $options, $_SERVER["DOCUMENT_ROOT"]."/design/img/lipton-logo.png" );
        	
            if(imagejpeg($image, $img_path))
                return true;
        	return false;
            
        }catch (Exception $e) {
        			
        	$e->getMessage();
            return false;	
        }
        return false;
    }
    
    
    


}