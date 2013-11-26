<?
class Files extends App
{
    public $unik_name;                      // ����� ��� �����
    public $pathBig   = "/files/img_o/"; // ������� � ������������� ���������� 
    public $pathSmall = "/files/img_s/"; // ������� � ������������ ���������� 
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
        
        list($txt,$ext) = explode(".", $name);      // ��������� �� ��� � ������
        
        if(in_array($ext,$this->valid_formats))     // ������� ������ ����� ��� �� ���������?!
        {
            if($size < (1024*1024*$this->mb))       // ������������ ������ ����� 
            {
                $user_id = $this->users->user_id;

                $this->unik_name = $user_id."-".time().".jpg"; // ������ ���������� ��� �����
                $tmp = $_FILES[$fileName]['tmp_name'];
                
                $imgPathBig   = $_SERVER["DOCUMENT_ROOT"].$this->pathBig.$this->unik_name;
                $imgPathSmall = $_SERVER["DOCUMENT_ROOT"].$this->pathSmall.$this->unik_name;
                
                if(move_uploaded_file($tmp, $imgPathBig)) // ��������� ���� � tmp � ��� �������
                { 
                    $params = getimagesize($imgPathBig);

                    switch ( $params[2] ) {
                      case 1: $source = imagecreatefromgif($imgPathBig); break;
                      case 2: $source = imagecreatefromjpeg($imgPathBig); break;
                      case 3: $source = imagecreatefrompng($imgPathBig); break;
                    }
                    
                    // ������������� �������� ��� ������������ 
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
                    $response['msg'] = '������� ������������ �����!';
                }
            }
            else 
            {
                $response['status'] = false;
                $response['msg'] = '����� ����� �� ������� ������������ '.$this->mb.'Mb!';
            }
        }
        else 
        {
            // ���������� ���������� 
            $this->errors->fix($this->users->user_id,$name);
            
            $response['status'] = false;
            $response['msg'] = '������� ������ �����!';
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
        
        // ����������� ���������� ������
        // (�� ������/������) ����������� ��������
        $max_size = 1024;
        // ���� ������ ��� ������ ������������ ��������
        // ������ ����������� ���������� ����������
        if ( $params[0]>$max_size || $params[1]>$max_size ) 
        {
            // �������� �������: ������ ��� ������
            // ������������ ��������
            if ( $params[0]>$params[1] ) $this->size = $params[0]; # ������
            else $this->size = $params[1]; # ������
            
            // �������� ������ � ������ ����������� ��������
            $k = $params[0]/200;
            $resource_width  = floor($params[0]/$k);
            $resource_height = floor($params[1]/$k);
            
            # �������� ����������
            $resource = imagecreatetruecolor($resource_width, $resource_height);
              
            # ��������� ������� � ����������� ����������� �� ����������
            imagecopyresampled($resource, $source, 0, 0, 0, 0,$resource_width, $resource_height, $params[0], $params[1]);
        }
        # ���� �������� ������ �� ���� ������ ����������� ����������
        # $resource ������������� ������������ ��������
        else 
            $resource = $source;

        # ������� ��������
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