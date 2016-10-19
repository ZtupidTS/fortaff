<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('v_home');
	}
	
	public function createplayer()
	{
		$result = $this->All_model->getlimit();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_createplayer', $data);
		}else{
			$data['result'] = $result;
			//isso é para quando vou de ver as picagens para essa pagina de corrigir picagens
			//assim não precido de reescrever outra pagina
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';	
			$this->load->view("v_createplayer", $data);
		}
	}
	
	public function insertplayer()
	{
		//print_r($this->input->post(NULL,TRUE));		
		$nickname = $this->input->post('nickname');
		$dateexpire = $this->input->post('dateexpire');
		$email = $this->input->post('email');
		$checkbox = $this->input->post('checkbox');
		$limitplay = $this->input->post('limit_play');
		$limitplay2 = $this->input->post('limit_play2');
		$limitplay3 = $this->input->post('limit_play3');
		$skype = $this->input->post('skype');
		$path = $this->input->post('path');
		
		if($limitplay2 == "0")
			$limitplay2 = "15";
			
		if($limitplay == "0")
			$limitplay = "15";
			
		if($limitplay3 == "0")
			$limitplay3 = "15";		
		
		$sql_data = array(
		            'nick_player'        	=> $nickname,
		            'limit_play'		=> $limitplay,
		            'limit_play2'		=> $limitplay2,
		            'limit_play3'		=> $limitplay3,
		            'expire_date'		=> $dateexpire,
		            'email'		=> $email,
		            'skype'		=> $skype,
		            'pathfolder'	=> $path,
		            'enable'		=> $checkbox	            
		        );
		
		$result = $this->All_model->addPlayer($sql_data);
		
		if($result)
	        {
			//$Logid = $this->db->insert_id();
			$return = array(
				'return' => 'success',
				//'Logid'  => $Logid,
				'message' => 'Player inserido com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'O Player não foi inserido, voltar a tentar');
			echo json_encode($return);
			return true;
		}
	}

	public function viewmodifyplayer()
	{
		$result = $this->All_model->getlimit();
		$result2 = $this->All_model->getplayers();
		if($result)
		{
			$data['result'] = $result;
			$data['result2'] = $result2;
			$this->load->view('v_modifyplayer', $data);
		}else{
			$data['result'] = $result;
			//isso é para quando vou de ver as picagens para essa pagina de corrigir picagens
			//assim não precido de reescrever outra pagina
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';	
			$this->load->view("v_modifyplayer", $data);
		}
	}
	
	public function viewallplayer()
	{
		$result = $this->All_model->getplayers();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view("v_allplayer", $data);
		}else{
			$data['result'] = $result;
			//isso é para quando vou de ver as picagens para essa pagina de corrigir picagens
			//assim não precido de reescrever outra pagina
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';	
			$this->load->view("v_allplayer", $data);
		}
	}

	public function getplayer()
	{
		$id_player = $this->input->post('id_player');
		$result = $this->All_model->getplayer($id_player);
		//print_r($result);
		if($result)
	        {
			//$Logid = $this->db->insert_id();
			$return = array(
				'return' => 'success',
				'nick_player' => $result[0]['nick_player'],
				'limit_play' => $result[0]['limit_play'],
				'limit_play2' => $result[0]['limit_play2'],
				'limit_play3' => $result[0]['limit_play3'],
				'pathfolder' => $result[0]['pathfolder'],
				'expire_date' => $result[0]['expire_date'],
				'email' => $result[0]['email'],
				'skype' => $result[0]['skype'],
				'enable' => $result[0]['enable']
				);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não foi possível obter o player');
			echo json_encode($return);
			return true;
		}
	}

	public function modifyplayer()
	{
		//print_r($this->input->post(NULL,TRUE));		
		$nickname = $this->input->post('nickname2');
		$dateexpire = $this->input->post('expire_date');
		$email = $this->input->post('email');
		$checkbox = $this->input->post('checkbox');
		$limitplay = $this->input->post('limit_play');
		$limitplay2 = $this->input->post('limit_play2');
		$limitplay3 = $this->input->post('limit_play3');
		$skype = $this->input->post('skype');
		$path = $this->input->post('pathfolder');
		$id = $this->input->post('id');
		
		if($limitplay2 == "0")
			$limitplay2 = "15";
			
		if($limitplay == "0")
			$limitplay = "15";
			
		if($limitplay3 == "0")
			$limitplay3 = "15";		
		
		$sql_data = array(
		            'nick_player'        	=> $nickname,
		            'limit_play'		=> $limitplay,
		            'limit_play2'		=> $limitplay2,
		            'limit_play3'		=> $limitplay3,
		            'expire_date'		=> $dateexpire,
		            'email'		=> $email,
		            'skype'		=> $skype,
		            'pathfolder'	=> $path,
		            'enable'		=> $checkbox	            
		        );
		
		$result = $this->All_model->modifyplayer($sql_data,$id);
		
		if($result)
	        {
			//$Logid = $this->db->insert_id();
			$return = array(
				'return' => 'success',
				//'Logid'  => $Logid,
				'message' => 'Player atualizado com sucesso');
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'O Player não foi atualizado, voltar a tentar');
			echo json_encode($return);
			return true;
		}
	}
	
	public function searchlog()
	{
		$this->load->helper('directory');
		$this->load->helper('file');
		
		$map = get_dir_file_info(APPPATH.'logs/');
		
		$datefirst = $this->input->post('datefirst');
		$datesecond = $this->input->post('datesecond');
		$typelog = $this->input->post('Typelog');
		
		//'ERROR' => 1, 'DEBUG' => 2, 'INFO' => 3, 'UTILIZADORES' => 4, 'ALL' => 5
		
		$files_exists = array();
		$searchString = "UTILIZADORES";	
		$message = '<table class="table table-hover logs table-borderless" id="logs"><thead><tr><th>Logs</th></tr></thead>';	
		
		foreach($map as $file)
		{
			if($file['name'] != 'index.html')
                	{
				if(strtotime($datefirst) <= $file['date'] && $file['date'] <= strtotime($datesecond . "+1 days"))
	                	{
					//array_push($files_exists,$file['name']);
					$contentfile = file_get_contents($file['server_path']);
					if($typelog != 'ALL')
					{
						if(strpos($contentfile, $typelog) !== false)
						{
							$handle = fopen($file['server_path'], "r");
							if ($handle) {
							    	while (($line = fgets($handle)) !== false) 
							    	{
							    		if(strpos($line, $typelog) !== false) 
							    		{
										$message .= '<tr><td>'.$line.'</td></tr>';
									}      
							    	}
							    	fclose($handle);
							}else{
								$message .= '<tr><td>Não Conseguiu abrir o ficheiro '.$file['server_path'].'</td></tr>';
							}
						}	
					}else{
						$handle = fopen($file['server_path'], "r");
						if ($handle) {
						    	while (($line = fgets($handle)) !== false) 
						    	{
						    		$message .= '<tr><td>'.$line.'</td></tr>';
						    	}
						    	fclose($handle);
						}else{
							$message .= '<tr><td>Não Conseguiu abrir o ficheiro '.$file['server_path'].'</td></tr>';
						}
					}
				}
			}
		}
		//echo $message;
		$message = $message . '</tbody></table>';
		$return = array(
			'return' => 'success',
			'message' => $message);
		echo json_encode($return);
		return true;
		
	}

	public function totaldia()
	{
		$result = $this->All_model->getlimit();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_totaldia', $data);
		}else{
			//isso é para quando vou de ver as picagens para essa pagina de corrigir picagens
			//assim não precido de reescrever outra pagina
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';	
			$this->load->view("v_totaldia", $data);
		}
	}
	
	public function totalplayer()
	{
		$result = $this->All_model->getplayers();
		
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_totalplayer', $data);
		}else{
			//isso é para quando vou de ver as picagens para essa pagina de corrigir picagens
			//assim não precido de reescrever outra pagina
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';	
			$this->load->view("v_totalplayer", $data);
		}
	}
	
	public function totalconvert()
	{
		$result = $this->All_model->getlimit();
		if($result)
		{
			$data['result'] = $result;
			$this->load->view('v_totalconverted', $data);
		}else{
			//isso é para quando vou de ver as picagens para essa pagina de corrigir picagens
			//assim não precido de reescrever outra pagina
			$data['erro'] = 'Problemas na obtenção dos dados, tentar novamente.';	
			$this->load->view("v_totalconverted", $data);
		}
	}	

	public function searchhanddia()
	{
		$datefirst = $this->input->post('datefirst');
		$datesecond = $this->input->post('datesecond');
		$id_limit = $this->input->post('id_limit');
		
		if($id_limit == '999999')
		{
			$result = $this->All_model->getresumohanddia($datefirst,$datesecond);
		}else{
			$result = $this->All_model->getresumohanddia($datefirst,$datesecond,$id_limit);	
		}
		
		//print_r($result);
		if($result)
		{
			$message_tb_head = '<table class="table table-hover handsdia display" id="handsdia"><thead><tr><th>Limit</th><th>Data</th><th>QTD</th></tr></thead>';
			
			$message = '';
			foreach($result as $row)
			{
				$message .= '<tr><td>'.$row['limit'].'</td><td>'.$row['data'].'</td><td>'.$row['qtd'].'</td></tr>';
			}
			$message = $message_tb_head . $message .'</tbody></table>';
			
			$return = array(
				'return' => 'success',
				'Logid'  => 'blabla',
				'message' => $message
				);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não foi possível obter dados, se o problema persistir contactar o administrador');
			echo json_encode($return);
			return true;
		}
	}

	public function searchplayerdia()
	{
		$datefirst = $this->input->post('datefirst');
		$datesecond = $this->input->post('datesecond');
		$id_player = $this->input->post('id_player');
		
		if($id_player == '999999')
		{
			$result = $this->All_model->getresumoplayerdia($datefirst,$datesecond);
		}else{
			$result = $this->All_model->getresumoplayerdia($datefirst,$datesecond,$id_player);	
		}
		
		//print_r($result);
		if($result)
		{
			$message_tb_head = '<table class="table table-hover handsdia display" id="handsdia"><thead><tr><th>Limit</th><th>Data</th><th>QTD</th><th>ID Player</th><th>Nickname</th></tr></thead>';
			
			$message = '';
			foreach($result as $row)
			{
				$message .= '<tr><td>'.$row['limit'].'</td><td>'.$row['data'].'</td><td>'.$row['qtd'].'</td><td>'.$row['idplayer'].'</td><td>'.$row['nickname'].'</td></tr>';
			}
			$message = $message_tb_head . $message .'</tbody></table>';
			
			$return = array(
				'return' => 'success',
				'Logid'  => 'blabla',
				'message' => $message
				);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não foi possível obter dados, se o problema persistir contactar o administrador');
			echo json_encode($return);
			return true;
		}
	}

	public function searchtotaldia()
	{
		$datefirst = explode("-",$this->input->post('datefirst'));
		$datesecond = explode("-",$this->input->post('datesecond'));
		$id_limit = $this->input->post('id_limit');
		
		if($id_limit == '999999')
		{
			$result = $this->All_model->gethandconverted($datefirst,$datesecond);
		}else{
			$result = $this->All_model->gethandconverted($datefirst,$datesecond,$id_limit);	
		}
		
		//print_r($result);
		if($result)
		{
			$message_tb_head = '<table class="table table-hover handsdia display" id="handsdia"><thead><tr><th>Limit</th><th>Data</th><th>QTD</th></tr></thead>';
			
			$message = '';
			foreach($result as $row)
			{
				$message .= '<tr><td>'.$row['limit'].'</td><td>'.$row['year'].'-'.$row['month'].'-'.$row['day'].'</td><td>'.$row['qtd'].'</td></tr>';
			}
			$message = $message_tb_head . $message .'</tbody></table>';
			
			$return = array(
				'return' => 'success',
				'Logid'  => 'blabla',
				'message' => $message
				);
			echo json_encode($return);
			return true;
		}else{
			$return = array(
				'return' => 'error',
				'message' => 'Não foi possível obter dados, se o problema persistir contactar o administrador');
			echo json_encode($return);
			return true;
		}
	}

}