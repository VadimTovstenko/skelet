<?
class Admin_Component_Validator
{

	private $_arr 	= array();
	private $_data 	= array();

	public function is_valid( array $data )
	{
		$this->_data = $data;

		if ( !empty( $this->_data ) )
		{
			foreach( $this->_data as $key => $val ) {

				if ( empty( $val ) ) {
					$this->_arr[$key] 	= true;
				} else {
					$this->_data[$key] = mysql_real_escape_string($val);
				}

			}

			if( empty( $this->_arr ) ) {
				return true;
			}
		}

		return false;
	}



	public function getInfo()
	{
		return $this->_arr;
	}



	public function getData()
	{
		return $this->_data;
	}


	public function checkEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return false;
	}
}