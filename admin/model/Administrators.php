<?
/**
 * Модель таблицы Administrators
 */
class Admin_Model_Administrators extends System_Model
{
	/**
	 * Название таблицы
	 * @var string
	 */
	private $_table = 'administrators';


	/**
	 * Получение данных записи администратора
	 * @param $name
	 * @return array|bool
	 */
	public function getByUserName( $name ) {

		$name = $this->escape($name);

		$this->db->query("SELECT * FROM " . $this->_table . " WHERE login = '" . $name . "' AND active = 1 LIMIT 1");
		return $this->db->result();
	}


	public function table()
	{
		return $this->_table;
	}



}
