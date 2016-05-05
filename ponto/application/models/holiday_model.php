<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holiday_model extends CI_Model {
	
	private $salt = 'r4nd0m';	
	//level 1: utilizador Normal da loja
	//level 2: utilizador admin
	
	
	
	/*
	* Devolve um array vazio se não tem resultado
	* Vais buscar todas as picagens
	*/
	/*public function getpicagens($sql_query)
	{
		$result = $this->db->query($sql_query);
		if($result->num_rows() >0)
		{
			return $result->result_array();
		}else{
			return array();
		}
	}*/
	
	/*
	* Atualizar feriado
	*/
	public function updateholiday($holidayid,$data)
	{
		$this->db->where('Holidayid', $holidayid);
	        $update = $this->db->update(TBL_HOLIDAY, $data);
	        return $update;
	}
	
	/*
	* Eliminar feriado
	*/
	public function deleteholiday($holidayid)
	{
		$this->db->where('Holidayid', $holidayid);
		$delete = $this->db->delete(TBL_HOLIDAY);
		return $delete;
	}
	
	/*
	* Insere uma picagem
	*/
	public function addholiday($data)
	{
		return $this->db->insert(TBL_HOLIDAY,$data);
	}
	
	/*
	* Obtenho todos os feriados criados
	*/
	public function getHoliday($id = false)
	{
		if(!$id)
		{
			$this->db->order_by("BDate","ASC");
			$get = $this->db->get(TBL_HOLIDAY);
			if($get->num_rows() > 0)
		    	{
		    		return $get->result_array();	
		    	} 
		    	return array();	
		}else{
			
		}
	}
}
?>