<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_model extends CI_Model {
	
	
	public function get($sql)
	{
		$result = $this->db->query($sql);
		if($result->num_rows() >0)
		{
			return $result->result_array();
		}else{
			return array();
		}
	}
	
	public function getrow($sql)
	{
		$result = $this->db->query($sql);
		if($result->num_rows() >0)
		{
			return $result->row();
		}else{
			return array();
		}
	}
	
	public function getlimit()
	{
		$sql = "select * from ".TBL_LIMIT;
		return $this->All_model->get($sql);
	}
	
	public function addPlayer($data)
	{
		return $this->db->insert(TBL_PLAYER,$data);
	}
	
	public function getplayers()
	{
		$sql = "select * from ".TBL_PLAYER;
		return $this->All_model->get($sql);
	}
	
	public function getplayersenable()
	{
		$sql = "select * from ".TBL_PLAYER." where enable = 1";
		return $this->All_model->get($sql);
	}
	
	public function getplayer($id)
	{
		$sql = "select * from ".TBL_PLAYER." where id_player = ".$id;
		return $this->All_model->get($sql);
	}
	
	public function modifyplayer($data,$id)
	{
		$this->db->where('id_player', $id);
	        $update = $this->db->update(TBL_PLAYER, $data);
	        return $update;
	}
	
	public function getfolder($path)
	{
		$sql = "select * from ".TBL_FOLDER." where path = '".$path."'";
		return $this->All_model->getrow($sql);
	}
	
	public function insertfolder($data)
	{
		return $this->db->insert(TBL_FOLDER,$data);
	}
	
	public function updatefolder($data,$path)
	{
		$this->db->where('path', $path);
	        $update = $this->db->update(TBL_FOLDER, $data);
	        return $update;
	}
}