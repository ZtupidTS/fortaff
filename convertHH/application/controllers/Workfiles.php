<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workfiles extends CI_Controller {

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
	public function readhand()
	{
		$this->load->helper('myfunction_helper');
		
		//ir buscar o jogadores ativo com nickname e path
		$players = $this->All_model->getplayersenable();
		
		//com isso vou ao path desses jogadores e por jogador até ao fim
		foreach($players as $elem)
		{
			$files_array = array();
			//folder
			if(file_exists($elem['pathfolder']))
			{
				$continu = true;
				$data = get_dir_file_info($elem['pathfolder'],0);
			
				if($data)
				{
					//agora para cada folder vou ver o size
					//e a ideia é percorrer em piramida
					$array_temp = array();
					
					while($data)
					{
						foreach($data as $elemfolder)
						{
							//echo $elemfolder['server_path'];
							$size = dirSize($elemfolder['server_path']);
							
							//agora com isso vou ver se existe e se tem o mesmo tamanho
							$folderdb = $this->All_model->getfolder($elemfolder['server_path']);
							if(isset($folderdb->size))
							{
								if($size != $folderdb->size)
								{
									array_push($data, $elemfolder['server_path']);
									//como o tamanho não é igual tenho que atualizar o tamanho na DB
									$sql_data = array(
									            'size'        	=> $size
									        );
									
									$result = $this->All_model->updatefolder($sql_data,$folderdb->path);
									if(!$result)
									{
										log_message('error', 'Não conseguiu aqtualizar o tamanho da pasta na DB');
										$continu = false;
									}
								}
							}else{
								//como não existe vou mete-lo na DB
								$sql_data = array(
								            'path'        	=> $elemfolder['server_path'],
								            'size'		=> $size
								        );
								
								$result = $this->All_model->insertfolder($sql_data);
								if(!$result)
							        {
									log_message('error', 'Não conseguiu inserir o caminho e tamanho da pasta na DB');
									$continu = false;
								}
								array_push($data, $elemfolder['server_path']);
							}
							
							if(!$continu)	
								break;	
								
							array_shift($data);			
						}
						if(!$continu)
							break;
						
						if($data)
						{
							for($i = 0;$i<count($data);$i++)	
							{
								$data_temp = get_dir_file_info($data[$i],0);
								//$data_temp = get_dir_file_info("/mnt/hh_share/HH/ricain/2016/DTMEU",1);
								
								foreach($data_temp as $elem_datatemp)	
								{
									if(is_dir($elem_datatemp['server_path']))
									{
										array_push($array_temp,$elem_datatemp);
									}else{
										array_push($files_array,$elem_datatemp['server_path']);
									}
								}
							}
							$data = $array_temp;
						}
						/*print_r($files_array);
						echo 'dafsdfasdfsfsfsfsfsfsfs sdf fsdf sfsf sf            fsdfaf asffsfsffsfs';
						print_r($data);
						break;*/
					}
				}
					
			}
			//files
			$files_final = array();
			foreach($files_array as $elem_files)
			{
				$size = filesize($elem_files);
				$filesdb = $this->All_model->getfolder($this->db->escape($elem_files));
				if(isset($filesdb->size))
				{
					if($size != $folderdb->size)
					{
						array_push($files_final, $elem_files);
						//como o tamanho não é igual tenho que atualizar o tamanho na DB
						$sql_data = array(
						            'size'        	=> $size
						        );
						
						$result = $this->All_model->updatefolder($sql_data,$this->db->escape($elem_files));
						if(!$result)
						{
							log_message('error', 'Não conseguiu aqtualizar o tamanho da pasta na DB');
							$continu = false;
						}
					}
				}else{
					//como não existe vou mete-lo na DB
					$sql_data = array(
					            'path'        	=> $this->db->escape($elem_files),
					            'size'		=> $size
					        );
					
					$result = $this->All_model->insertfolder($sql_data);
					if(!$result)
				        {
						log_message('error', 'Não conseguiu inserir o caminho e tamanho da pasta na DB');
						$continu = false;
					}
					array_push($files_final, $elem_files);
				}	
			}
			//agora vou tratar dos ficheiros
			$filesdb = $this->All_model->getfolder("/mnt/hh_share/HH/ricain2/2016/08/26/HH20160826 Balduinus - €0.10-€0.20 - EUR No Limit Hold\'em_1.txt");
			//print_r($filesdb);
			if(file_exists($filesdb->path))
				echo 'yes';
		}
		
		//print_r($players);
		
		
		//$data = get_dir_file_info("/mnt/hh_share/HH/ricain",0);
		//$size = dirSize($data['2016']['server_path']);
		//print_r($data);
		
	}
	
	 
}