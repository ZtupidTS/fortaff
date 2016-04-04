<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	private $salt = 'r4nd0m';
	public $USER_LEVEL_ADMIN = 1;
	public $USER_LEVEL_PM = 2;
	public $USER_LEVEL_DEV = 3;

	public function get($id = false)
	{
		if ($id) $this->db->where('id', $id);
		$this->db->order_by('email', 'asc');
		$get = $this->db->get('user');
		if($id) return $get->row_array();
		if($get->num_rows() > 0) return $get->result_array();
		return array();
	}
	public function create($data)
	{
		$data['password'] = sha1($data['password'].$this->salt);
		//$data['password'] = sha1($data['password']);
		return $this->db->insert('user', $data);
	}
	public function validate($email, $password)
	{
	    //echo $email;
	    //echo $password. ' ';
	    //echo sha1($password) . ' ';
	    $this->db->where('email', $email)->where('password', sha1($password.$this->salt));
	    //$this->db->where('email', $email)->where('password', sha1($password));
	    //$this->db->where('email', 'test@test.fr')->where('password', '7c4a8d09ca3762af61e59520943dc26494f8941b');
	    $get = $this->db->get('user');
	    //$get = $this->db->query("SELECT * FROM user WHERE email = 'test@test.fr' and password = '7c4a8d09ca3762af61e59520943dc26494f8941b'");
	    //print_r($get);
	    //echo $get->num_rows() . ' dddd';
	    if($get->num_rows() > 0) return $get->row_array();
	    return array();
	}
	
	public function update($id, $data)
	{
	    if(isset($data['password']))
	        $data['password'] = sha1($data['password'].$this->salt);
	    $this->db->where('id', $id);
	    $update = $this->db->update('user', $data);
	    return $update;
	}
	
	public function delete($id)
	{
	    $this->db->where('id', $id);
	    $this->db->delete('user');
	}
}
?>