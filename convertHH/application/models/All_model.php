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
			return null;
		}
	}
	
	public function getlimit()
	{
		$sql = "select * from ".TBL_LIMIT;
		return $this->All_model->get($sql);
	}
	
	public function getlimitbyname($name_limit)
	{
		$sql = "select * from ".TBL_LIMIT." where name_limit = '".$name_limit."'";
		return $this->All_model->getrow($sql);
	}
	
	public function getlimitbyid($id_limit)
	{
		$sql = "select name_limit from ".TBL_LIMIT." where id_limit = '".$id_limit."'";
		return $this->All_model->getrow($sql);
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
		$sql = "select * from ".TBL_FOLDER." where path = '".$this->db->escape_str($path)."'";
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
	
	public function inserthand($data)
	{
		return $this->db->insert(TBL_NUMHZOOM,$data);
	}
	
	public function getallnickname()
	{
		$sql = "select name_nickname from ".TBL_NICKNAME;
		$result = $this->db->query($sql);
		if($result->num_rows() >0)
		{
			$elem_nick = $result->result_array();
			$array_nick = array();
			foreach($elem_nick as $elem_nick2)
			{
				array_push($array_nick,$elem_nick2['name_nickname']);
			}
			return $array_nick;
		}else{
			log_message('error', 'Não conseguiu obter os nicknames que são para alterar (All_model linha 102)');
			return array();
		}
	}
	
	public function numhands($id_player,$id_limit,$date)
	{
		$sql = "select qtd, id_hand from ".TBL_QTDHANDS." where id_player = ".$id_player." AND id_limit = ".$id_limit." AND date = ".$date;
		$result = $this->db->query($sql);
		if($result->num_rows() >0)
		{
			$elem_qtd = $result->row();
			$array_row = array(
				intval($elem_qtd->qtd),
				$elem_qtd->id_hand
				);
			return $array_row;
		}else{
			return array();
		}
	}
	
	public function updatenumhands($data,$id_hand)
	{
		$this->db->where('id_hand', $id_hand);
	        $update = $this->db->update(TBL_QTDHANDS, $data);
	        return $update;
	}
	
	public function insertnumhands($data)
	{
		return $this->db->insert(TBL_QTDHANDS,$data);
	}
	
	public function getlastnamefile($id_limit,$year,$month,$day)
	{
		$sql = "select namefile from ".TBL_FILECONVERT." where id_limit = ".$id_limit." AND year = ".$year." AND month = ".$month." AND day = ".$day." ORDER BY id DESC LIMIT 1";
		$result = $this->db->query($sql);
		if($result->num_rows() >0)
		{
			$elem_namefile = $result->row();
			return intval($elem_namefile->namefile) + 1;
		}else{
			return 1;
		}
	}
	
	public function insertfileshands($data)
	{
		return $this->db->insert(TBL_FILECONVERT,$data);
	}
	
	public function getfilesconvertbynorid($id_player,$id_limit,$date)
	{
		$sql = "select * from ".TBL_FILECONVERT." where id_player != ".$id_player." AND id_limit = ".$id_limit." AND year = ".$date[0]." AND month = ".$date[1]." AND day = ".$date[2];
		return $this->All_model->get($sql);
	}
	
	public function sumconvertbynorid($id_player,$id_limit,$date)
	{
		$sql = "select sum(num_hands) as totalhands from ".TBL_FILECONVERT." where id_player != ".$id_player." AND id_limit = ".$id_limit." AND year = ".$date[0]." AND month = ".$date[1]." AND day = ".$date[2];
		$result = $this->db->query($sql);
		if($result->num_rows() >0)
		{
			$elem_numhands = $result->row();
			return intval($elem_numhands->totalhands);
		}else{
			return 0;
		}
	}
	
	public function getresumohanddia($firstday,$secondday,$id_limit = false)
	{
		if($id_limit)
		{
			$sql = "select li.name_limit as 'limit', nh.date as 'data', sum(nh.qtd) as 'qtd' from ".TBL_QTDHANDS." nh, ".TBL_LIMIT." li where li.id_limit = nh.id_limit AND nh.date between '".$firstday."' AND DATE_ADD('".$secondday."', INTERVAL 1 DAY) AND li.id_limit = ".$id_limit." group by li.name_limit, nh.date";
		}else{
			$sql = "select li.name_limit as 'limit', nh.date as 'data', sum(nh.qtd) as 'qtd' from ".TBL_QTDHANDS." nh, ".TBL_LIMIT." li where li.id_limit = nh.id_limit AND nh.date between '".$firstday."' AND DATE_ADD('".$secondday."', INTERVAL 1 DAY) group by li.name_limit, nh.date";
		}
		return $this->get($sql);
	}
	
	public function getresumoplayerdia($firstday,$secondday,$id_player = false)
	{
		if($id_player)
		{
			$sql = "select li.name_limit as 'limit', nh.date as 'data', sum(nh.qtd) as 'qtd', pl.nick_player as 'nickname', pl.id_player as 'idplayer', pl.expire_date as 'dateexpire', pl.enable as 'enable' from ".TBL_QTDHANDS." nh, ".TBL_PLAYER." pl, ".TBL_LIMIT." li where nh.id_player = pl.id_player AND li.id_limit = nh.id_limit AND nh.date between '".$firstday."' AND DATE_ADD('".$secondday."', INTERVAL 1 DAY) AND nh.id_player = ".$id_player." group by li.name_limit, nh.date,pl.nick_player,pl.id_player,pl.expire_date,pl.enable";
		}else{
			$sql = "select li.name_limit as 'limit', nh.date as 'data', sum(nh.qtd) as 'qtd', pl.nick_player as 'nickname', pl.id_player as 'idplayer', pl.expire_date as 'dateexpire', pl.enable as 'enable' from ".TBL_QTDHANDS." nh, ".TBL_PLAYER." pl, ".TBL_LIMIT." li where nh.id_player = pl.id_player AND li.id_limit = nh.id_limit AND nh.date between '".$firstday."' AND DATE_ADD('".$secondday."', INTERVAL 1 DAY) group by li.name_limit, nh.date,pl.nick_player,pl.id_player,pl.expire_date,pl.enable";
		}
		
		/*$sql = "select li.name_limit as 'limit', nh.date as 'data', sum(nh.qtd) as 'qtd', pl.nick_player as 'nickname', pl.id_player as 'idplayer', pl.expire_date as 'dateexpire', pl.enable as 'enable' from ".TBL_QTDHANDS." nh, ".TBL_PLAYER." pl, ".TBL_LIMIT." li where nh.id_player = pl.id_player AND li.id_limit = nh.id_limit AND nh.date between '".$firstday."' AND DATE_ADD('".$secondday."', INTERVAL 1 DAY) group by li.name_limit, nh.date,pl.nick_player,pl.id_player,pl.expire_date,pl.enable";*/
		
		return $this->get($sql);
	}
	
	public function gethandconverted($firstday,$secondday,$id_limit = false)
	{
		if($id_limit)
		{
			$sql = "SELECT sum(fi.num_hands) as 'qtd', fi.year as 'year', fi.month as 'month', fi.day as 'day', li.name_limit as 'limit' from ".TBL_FILECONVERT." fi, ".TBL_PLAYER." pl, ".TBL_LIMIT." li where fi.id_player = pl.id_player AND li.id_limit = fi.id_limit AND fi.year >= '".$firstday[0]."' AND fi.month >= '".$firstday[1]."' AND fi.day >= '".$firstday[2]."' AND fi.year <= '".$secondday[0]."' AND fi.month <= '".$secondday[1]."' AND fi.day <= '".$secondday[2]."' AND li.id_limit = ".$id_limit." group by fi.year,fi.month,fi.day,li.name_limit";
		}else{
			$sql = "SELECT sum(fi.num_hands) as 'qtd', fi.year as 'year', fi.month as 'month', fi.day as 'day', li.name_limit as 'limit' from ".TBL_FILECONVERT." fi, ".TBL_PLAYER." pl, ".TBL_LIMIT." li where fi.id_player = pl.id_player AND li.id_limit = fi.id_limit AND fi.year >= '".$firstday[0]."' AND fi.month >= '".$firstday[1]."' AND fi.day >= '".$firstday[2]."' AND fi.year <= '".$secondday[0]."' AND fi.month <= '".$secondday[1]."' AND fi.day <= '".$secondday[2]."' group by fi.year,fi.month,fi.day,li.name_limit";
		}
		return $this->get($sql);
	}
	
}