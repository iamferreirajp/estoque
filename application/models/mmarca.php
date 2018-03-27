<?php 

class MMarca extends CI_Model{

	function addMarca($data)
	{
		$this->db->insert('marca', $data);
	}

	function listMarca()
	{
		return $this->db->get('marca');
	}

	function getMarca($id)
	{
		return $this->db->get_where('marca', array('id'=> $id));
	}

	function updateMarca($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('marca', $data); 
	}

	function deleteMarca($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('marca'); 
	}

}

/* End of file mcategoria.php */
/* Location: ./system/application/models/mcategoria.php */