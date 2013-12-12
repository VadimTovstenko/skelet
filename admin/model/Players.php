<?
/**
 * Модель таблицы Players
 */
class Admin_Model_Players extends System_Model
{
	/**
	 * Название таблицы
	 * @var string
	 */
	private $_table = 'players';


	/**
	 * Получение данных записи администратора
	 * @return array|bool
	 */
	public function getAll()
	{
		$admin = new Admin_Model_Administrators();
		$adminTable = $admin->table();
		$table = $this->_table;

		$this->db->query('
									SELECT
										' . $table . '.id,
										' . $table . '.username,
										' . $table . '.first_name,
										' . $table . '.last_name,
										' . $table . '.birth_date,
										' . $table . '.email,
										' .$adminTable . '.login as adminLogin
									FROM ' . $table . '
									LEFT JOIN ' .$adminTable . '
									ON ' . $adminTable . '.id = ' . $table . '.admin_id
									');

		return $this->db->results();
	}


	/**
	 * Добавление игрока в ДБ
	 * @param array $data
	 * @return int
	 */
	public function add( array $data )
	{
		$this->db->query("
									INSERT INTO " . $this->_table . " SET
									username 	= '" .$data['username']. "',
									first_name = '" .$data['first_name']. "',
									last_name 	= '" .$data['last_name']. "',
									birth_date 	= '" .$data['birth_date']. "',
									email 		= '" .$data['email']. "',
									admin_id	= '" .$data['admin_id']. "'
		 							");

		return $this->db->insert_id();
	}


	/**
	 * Редактирование данных игрока
	 * @param array $data
	 * @return bool
	 */
	public function edit( array $data )
	{
		$this->db->query("
									UPDATE " . $this->_table . " SET
									first_name = '" .$data['first_name']. "',
									last_name 	= '" .$data['last_name']. "',
									birth_date 	= '" .$data['birth_date']. "',
									email 		= '" .$data['email']. "'
									WHERE id 	= '" .$data['player_id']. "'
		 							");

		return true;
	}


	public function delete($id)
	{
		$id = $this->escape($id);
		$this->db->query("DELETE FROM  " . $this->_table . " WHERE id = ".$id );
		return $this->db->affected_rows();
	}

	public function deleteByIds($ids)
	{
		$ids = $this->escape($ids);
		$this->db->query("DELETE FROM  " . $this->_table . " WHERE id IN (".$ids.")" );
		return $this->db->affected_rows();
	}


	public function getByName($name)
	{
		$name = $this->escape($name);

		$this->db->query("SELECT * FROM " . $this->_table . " WHERE username = '" . $name . "' LIMIT 1");
		return $this->db->result();
	}


	public function getById($id)
	{
		$id = (int) $id;

		$this->db->query("SELECT * FROM " . $this->_table . " WHERE id = '" . $id . "' LIMIT 1");
		return $this->db->result();
	}



}
