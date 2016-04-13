<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Picagem_model extends CI_Model {
	
	private $salt = 'r4nd0m';	
	//level 1: utilizador Normal da loja
	//level 2: utilizador admin
	
	//TBL_PICAGENS
	
	/*
	* Devolve um array vazio se n~qao tem resultado
	*/
	public function getpicagens($sql_query)
	{
		$result = $this->db->query($sql_query);
		if($result->num_rows() >0)
		{
			return $result->result_array();
		}else{
			return array();
		}
	}
}
?>