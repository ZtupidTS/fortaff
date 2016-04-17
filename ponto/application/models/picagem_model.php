<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Picagem_model extends CI_Model {
	
	private $salt = 'r4nd0m';	
	//level 1: utilizador Normal da loja
	//level 2: utilizador admin
	
	//TBL_PICAGENS
	
	/*
	* Devolve um array vazio se não tem resultado
	* Vais buscar todas as picagens
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
	
	/*
	* Devolve as picagens do dia o intervalo de dias de um user
	*/
	public function picagensbyuser($iduser,$datafirst, $datasecond = false)
	{
		$date1 = explode('-',$datafirst);
		
		if($datasecond)
		{
			//se existe uma segunda data
			$date2 = explode('-',$datasecond);
			/*$this->db->where('Userid', $iduser);
			$this->db->where('datepart(day,CheckTime)', $date1[2]);
			$this->db->where('datepart(month,CheckTime)', $date1[1]);
			$this->db->where('datepart(year,CheckTime)', $date1[0]);*/
			$sql = "select * from V_Record where Userid= ".$iduser." AND CheckTime between '".$datafirst."' and DATEADD(DAY,1,'".$datasecond."')";
			return getpicagens($sql);
		}else{
			$this->db->where('Userid', $iduser);
			$this->db->where('datepart(day,CheckTime)', $date1[2]);
			$this->db->where('datepart(month,CheckTime)', $date1[1]);
			$this->db->where('datepart(year,CheckTime)', $date1[0]);
		}
		
		$get = $this->db->get(TBL_VPICAGENS);
	    	//aqui vou ver se o user ja entrou uma vez
	    	if($get->num_rows() > 0)
	    	{
	    		return $get->result_array();	
	    	} 
	    	return array();
	}
	
	/*
	*
	*/
	public function updatepicagem($logid,$data)
	{
		$this->db->where('Logid', $logid);
	        $update = $this->db->update(TBL_PICAGENS, $data);
	        return $update;
	}
	
	
}
?>