<?php
	
/**
 * Watermark - Watermark image with text or image.
 *
 */	
class Watermark {
	
	private $options = array(
		'watermark_position' => 'top_right', //position (top_left, bottom_left, top_right, bottom_right)
		'vertically' => 0, //distance from top or bottm side of image
		'horizontally' => 0,//distance from left or right side of image
		'text_color' => '#ffffff', // color of text watermark
		'text_font' => 'arial.ttf', //font file to put watermark
		'text_alpha' => '50', //opacity of text watermark
		'text_size' => '24' //watermark font size
	);
	
	/**
	* Setting default options for watermark
	*
	* @param resource $imageResource - image to watermark
	* @param array $options - required options
	* @param string $watermark_path - path to watermark image file
	* @param string $text - text of type text watermark
	* 
	* @return exception|imageresource
	*/
	public function init( $imageResource, $options = array(), $watermark_path = false, $text = false )
	{
 		if( !is_resource($imageResource) )
		{
			throw new Exception('Image is not valid image resource');
		}
		
		if( !isset($options['watermark_type']) )
		{
			throw new Exception('Fill all options');
		}
		
		if( !isset($options['orginal_width']) || !isset($options['orginal_height']) )
		{
			$this->options['orginal_width'] = imagesx( $imageResource );
			$this->options['orginal_height'] = imagesy( $imageResource );
		}
		
		$this->options = $this->setOptions( $options );
		
		if( $this->options['watermark_type'] == 'image' )
		{
			return $this->imageWatermark( $imageResource, $watermark_path );
		}
		elseif( $this->options['watermark_type'] == 'text' )
		{
			return $this->textWatermark( $imageResource, $text );
		}
		else
		{
			throw new Exception('Type correct watermark type');
		}
	}
	/**
	* Fill options with defaults ifwasn't set
	*
	* @param array $options
	* 
	* @return array $options
	*/
	public function setOptions( $options ){
	
		
		foreach( $this->options as $key => $val )
		{
			if( !isset( $options[$key] ) )
			{
				$options[$key] = $val;
			}
		}
		return $options;
	}
	/**
	* Watermark image resource with another image
	*
	* @param resource $imageResource - image to watermark
	* @param string $watermark_path - path to watermark image file
	* 
	* @return exception|imageresource
	*/
	public function imageWatermark( $imageResource, $watermark_path ){
			
		if( file_exists( $watermark_path ) )
		{
			list($width, $height, $type, $attr) = getimagesize( $watermark_path );
			
			$filetype = image_type_to_extension( $type, false );
			
			if( $filetype != 'png' )
			{
				throw new Exception('Watermark file must be PNG');
			}
			
			$watermark = imagecreatefrompng( $watermark_path );
			$watermark_width = imagesx($watermark);
			$watermark_height = imagesy($watermark);
			
			imagealphablending($imageResource, true);
			imagealphablending($watermark, true);
			
			if( $this->options['watermark_position'] == 'top_left' )
			{
				$position_x = $this->options['horizontally'];
				$position_y = $this->options['vertically'];
			}
			elseif( $this->options['watermark_position'] == 'top_right' )
			{
				$position_x = $this->options['orginal_width']  - $watermark_width + $this->options['horizontally'];
				$position_y = $this->options['vertically'];
			}
			elseif( $this->options['watermark_position'] == 'bottom_left' )
			{
				$position_x = $this->options['horizontally'];
				$position_y = $this->options['orginal_height']  - $watermark_height - $this->options['vertically'];
			}
			else
			{
				$position_x = $this->options['orginal_width']  - $watermark_width - $this->options['horizontally'];
				$position_y = $this->options['orginal_height']  - $watermark_height - $this->options['vertically'];
			}
				
			imagecopy($imageResource, $watermark, $position_x, $position_y, 0, 0, $watermark_width, $watermark_height);	
			imagedestroy($watermark);
		}
		else
		{
			throw new Exception('Watermark file does not exists');
		}
		
		return $imageResource;
	}
	
	/**
	* Watermak image with text
	*
	* @param resource $imageResource - image to watermark
	* @param string $text - text of type text watermark
	* 
	* @return exception|imageresource
	*/
	public function textWatermark( $imageResource, $text ){
			
		if( !file_exists( $this->options['text_font'] ) )
		{
			throw new Exception('Font file ' . $this->options['text_font'] . 'does not exists');
		}
		if( empty( $text ) || strlen($text) > 20 )
		{
			throw new Exception('Watermark text is empty or too long');
		}
		$img = imagecreatetruecolor(100, 50);
		$color = HexToRGB( $this->options['text_color'] );
		$color = imagecolorallocatealpha( $img, $color['r'], $color['g'], $color['b'], $this->options['text_alpha'] );
		
		$rozmiary = calculateTextBox( $this->options['text_size'], $this->options['text_font'], $text );		
		
		if( $this->options['watermark_position'] == 'top_left' )
		{
			$position_x = $this->options['horizontally'];
			$position_y = $this->options['vertically'] + $rozmiary['height'];
		}
		elseif( $this->options['watermark_position'] == 'top_right' )
		{
			$position_x = $this->options['orginal_width']   - $rozmiary['width'] + $this->options['horizontally'];
			$position_y = $this->options['vertically'] + $rozmiary['height'];
		}
		elseif( $this->options['watermark_position'] == 'bottom_left' )
		{
			$position_x = $this->options['horizontally'];
			$position_y = $this->options['orginal_height']  - 5 - $this->options['vertically'];
		}
		else
		{
			$position_x = $this->options['orginal_width']  - $rozmiary['width'] - $this->options['horizontally'];
			$position_y = $this->options['orginal_height']  - 5 - $this->options['vertically'];
		}

		imagettftext($imageResource, $this->options['text_size'], 0, $position_x, $position_y, $color, $this->options['text_font'], $text);
		
		return $imageResource;
	}
}
?>