<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	private $salt = 'r4nd0m';	
	//level 1: utilizador Normal da loja
	//level 2: utilizador admin
	//level 3: chefes
	
	//obter um user pelo id ou obter todos os users
	public function get($number_user = false)
	{
		if ($number_user) $this->db->where('Userid', $number_user);
		//$this->db->order_by('email', 'asc');
		$get = $this->db->get(TBL_USERS);
		if($number_user) return $get->row_array();
		if($get->num_rows() > 0) return $get->result_array();
		return array();
	}
	
	//para o login
	public function login($number, $password)
	{
	    	if($password == "")
	    	{
			$this->db->where('Userid', $number);	
		}else{
			$this->db->where('Userid', $number)->where('Telephone', $password);
		}
	    	$get = $this->db->get(TBL_USERS);
	    	//aqui vou ver se o user ja entrou uma vez
	    	if($get->num_rows() > 0)
	    	{
	    		$result = $get->row_array();
	    		if($result['Telephone'] != "" && $password == "")
	    		{
				return array();
			}else{
				return $get->row_array();	
			}
	    	} 
	    	return array();
	}
	
	//update
	public function update($user_id, $data)
	{
		$this->db->where('Userid', $user_id);
	    	$update = $this->db->update(TBL_USERS, $data);
	    	return $update;
	}
	
	/*
	* Obter todos os users
	*/
	public function getAll()
	{
		$get = $this->db->get(TBL_USERS);
		if($get->num_rows() > 0)
	    	{
	    		return $get;
	    	}else{
			return array();	
		}
	}
}
?>