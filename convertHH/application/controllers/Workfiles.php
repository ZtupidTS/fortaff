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
		
		//vou apagar a tabela de foldersize mas só para o desenvolvimento
		/*$this->db->empty_table(TBL_FOLDER);
		$this->db->empty_table(TBL_NUMHZOOM);
		$this->db->empty_table(TBL_FILECONVERT);
		$this->db->empty_table(TBL_QTDHANDS);*/
		
		//ir buscar o jogadores ativo com nickname e path
		$players = $this->All_model->getplayersenable();
		
		//com isso vou ao path desses jogadores e por jogador até ao fim
		foreach($players as $elem)
		{
			$files_array = array();
			$continu = true;
			//folder
			if(file_exists($elem['pathfolder']))
			{
				$data = get_dir_file_info($elem['pathfolder'],0);
			
				if($data)
				{
					//agora para cada folder vou ver o size
					//e a ideia é percorrer em piramida
					$array_temp = array();
					
					while($data)
					{
						//print_r($data);
						
						foreach($data as $elemfolder)
						{
							//echo $elemfolder['server_path'].' ';
							
							if(is_dir($elemfolder['server_path']))
							{
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
								
							}else{
								array_push($files_array,$elemfolder['server_path']);
							}
							array_shift($data);			
						}
						if(!$continu)
							break;
						
						//print_r($data);
						
						if($data)
						{
							for($i = 0;$i<count($data);$i++)	
							{
								//echo ' d   ';
								//echo $data[$i].' fdfdf    ';
								//print_r(get_dir_file_info($data[$i],0));
								//echo '       fdffdf         ';
								
								$data_temp = get_dir_file_info($data[$i],0);
								//$data_temp = get_dir_file_info("/mnt/hh_share/HH/ricain/2016/DTMEU",1);
								if($data_temp)
								{
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
							}
							$data = $array_temp;
							$array_temp = array();
						}
						//print_r($files_array);
						//echo 'dafsdfasdfsfsfsfsfsfsfs sdf fsdf sfsf sf            fsdfaf asffsfsffsfs ';
						//print_r($data);
						//shell_exec("sleep 15");
						//echo count($data). '\n';
						//break;
					}
				}	
			}
			//files
			$files_final = array();
			foreach($files_array as $elem_files)
			{
				$size = filesize($elem_files);
				$filesdb = $this->All_model->getfolder($elem_files);
				if(isset($filesdb->size))
				{
					if($size != $filesdb->size)
					{
						array_push($files_final, $elem_files);
						//echo $size.'   '.$filesdb->size.'  fim  ';
						//como o tamanho não é igual tenho que atualizar o tamanho na DB
						$sql_data = array(
						            'size'        	=> $size
						        );
						
						$result = $this->All_model->updatefolder($sql_data,$elem_files);
						if(!$result)
						{
							log_message('error', 'Não conseguiu aqtualizar o tamanho da pasta na DB');
							$continu = false;
						}
					}
				}else{
					//como não existe vou mete-lo na DB
					$sql_data = array(
					            'path'        	=> $elem_files,
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
			//print_r($files_final);
			foreach($files_final as $elem_finalfiles)
			{
				$filesdb = $this->All_model->getfolder($elem_finalfiles);
				if(isset($filesdb))
				{
					if(file_exists($filesdb->path))
					{
						$new_file = $this->workfileshand($filesdb->path,$elem['id_player'],$elem['nick_player'],$elem['room'],$elem['type']);
						//echo $filesdb->path.'             ';
					}else{
						log_message('error', 'ficheiro não existe (workfiles line 173)');
						$continu = false;
					}
				}else{
					log_message('error', 'Não obteve o path do ficheiro na DB (workfiles line 177)');
					$continu = false;
				}
				if(!$continu)
					break;
			}
			exec ("chmod 777 -R ".VAR_PATHCONVERTED);
		}
	}
	
	function workfileshand($file_path,$id_player,$nick_original,$room,$type)
	{
		$continu_room = true;
		
		if($room == "EU")
		{
			$this->converthandEuZoom($file_path,$id_player,$nick_original);
			$continu_room = false;	
		}
		
		if($room == "PT" && $continu_room)
		{
			if($type == "SH")
			{
				$this->convetHandPtReg($file_path,$id_player,$nick_original);
				$continu_room = false;
			}
			if($type == "ZO" && $continu_room)
			{
				$continu_room = false;
			}
		}
	}
	
	function converthandEuZoom($file_path,$id_player,$nick_original)
	{
		$array_nickname = $this->All_model->getallnickname();
		
		$file_read = file_get_contents($file_path);
		//echo $file_read;
		$new_file = "";
		$date_old = "";
		$qtd_hand = 0;
		
		if (strpos($file_read,"PokerStars Zoom") !== false) 
		{
			$p = true;
			$hand_old = false;
			$arr_file_read = explode("PokerStars",$file_read);
			
			//echo count($arr_file_read).' ';
			//print_r($arr_file_read);
			//ok ate aqui tenho hands
			
			for($m = 1;$m<count($arr_file_read);$m++)
			{
				$num_hand = 0;
				
				//echo $arr_file_read[$m].'             ';
				//echo $m;
				
				if($arr_file_read[$m] != "")
				{
					if(strpos($arr_file_read[$m],"Seat 9") === false)
					{
						//vou ler a primeira linha só
						//echo $arr_file_read[$m]. '            ';
						$str = strtok($arr_file_read[$m], "\r\n");
						//echo $str.'                      ';
						if(strpos($str,"Hold'em No Limit") !== false)
						{
							//limit hand
							//NLxx
							if($p)
							{
								$limit = getStringBetween($str,"(",")");
								$limit = findlimithand($limit);
								//id limit DB
								$limit_temp = $this->All_model->getlimitbyname($limit);
								$limit_final = $limit_temp->id_limit;
							}
							//data
							$date_new = str_replace("/","-",getStringBetween($str,"- "," "));
							//só vou guardar 1 ano de hands
							//echo $date_new.'     ';
							//echo strtotime($date_new).'     ';
							//echo strtotime("now -1 year").'     ';
							if(strtotime($date_new) > strtotime("now -1 year"))
							{
								//numero da hand
								$num_hand = getStringBetween($str,"#",":");
								//meter na DB
								$sql_data = array(
								            'numhands'        	=> $num_hand,
								            'playerHH'		=> $id_player
								        );
								
								$result = $this->All_model->inserthand($sql_data,$num_hand);
								if(!$result)
								{
									log_message('error', 'Não conseguiu inserir a hand na DB ou duplicate');
								}else{
									//alterar o nick do player
									$new_nick = $array_nickname[rand(0,299)];
									$new_hand = str_replace($nick_original,$new_nick,$arr_file_read[$m]);
									//Criar o novo string da hand e meter na varíavel
									$new_file .= "PokerStars".$new_hand;
									//echo $new_file;
									$qtd_hand++;
								}
							}else{
								//echo 'aaaaaa';
								$hand_old = true;
							}
							$p = false;
						}else{
							//echo 'bbbbbbbbb';
							$hand_old = true;
						}
					}else{
						$hand_old = true;
					}
				}
				if($hand_old)
					break;
			}
			//echo $new_file;
			//acabei de ler o ficheiro
			//meter na DB (TBL_QTDHANDS e TBL_FILECONVERT) + na pasta de partilha para os gajos
			//TBL_QTDHANDS
			//antes de inserir ver se já existe algo do género na DB
			if(!$hand_old && $new_file != "")
			{
				$array_numhand = $this->All_model->numhands($id_player,$limit_final,$date_new);
				if($array_numhand)
				{
					//update
					$new_numhand = $array_numhand[0] + $qtd_hand;
					$sql_data = array(
					            'id_player'        	=> $id_player,
					            'id_limit'		=> $limit_final,
					            'date'		=> $date_new,
					            'qtd'		=> $new_numhand 
					        );
					$result = $this->All_model->updatenumhands($sql_data,$array_numhand[1]);
					if(!$result)
					{
						log_message('error', 'Não conseguiu fazer o update de num hands (workfiles linha 274');
					}
				}else{
					//insert
					$sql_data = array(
					            'id_player'        	=> $id_player,
					            'id_limit'		=> $limit_final,
					            'date'		=> $date_new,
					            'qtd'		=> $qtd_hand 
					        );
					$result = $this->All_model->insertnumhands($sql_data);
					if(!$result)
					{
						log_message('error', 'Não conseguiu inserir o numero de hands (workfiles linha 287');
					}
				}
				//TBL_FILECONVERT
				$today = todaysplit();
				//criar a pasta caso não existe
				if(!file_exists(VAR_PATHCONVERTED."/".$limit))
				{
					mkdir(VAR_PATHCONVERTED."/".$limit, 0777, true);						
				}
				if(!file_exists(VAR_PATHCONVERTED."/".$limit."/".$today[0]))
				{
					mkdir(VAR_PATHCONVERTED."/".$limit."/".$today[0], 0777, true);						
				}
				if(!file_exists(VAR_PATHCONVERTED."/".$limit."/".$today[0]."/".$today[1]))
				{
					mkdir(VAR_PATHCONVERTED."/".$limit."/".$today[0]."/".$today[1], 0777, true);
				}
				if(!file_exists(VAR_PATHCONVERTED."/".$limit."/".$today[0]."/".$today[1]."/".$today[2]))
				{
					mkdir(VAR_PATHCONVERTED."/".$limit."/".$today[0]."/".$today[1]."/".$today[2], 0777, true);
				}
				//criar o ficheiro de hands
				$namefile = $this->All_model->getlastnamefile($limit_final,$today[0],$today[1],$today[2]);
				$myfile = fopen(VAR_PATHCONVERTED."/".$limit."/".$today[0]."/".$today[1]."/".$today[2]."/".$namefile.".txt", "w");
				fwrite($myfile, $new_file);
				fclose($myfile);
				//meter na DB
				$sql_data = array(
				            'num_hands'        	=> $qtd_hand,
				            'id_limit'		=> $limit_final,
				            'year'		=> $today[0],
				            'month'		=> $today[1], 
				            'day'		=> $today[2],
				            'namefile'		=> $namefile,
				            'room'		=> 'EU',
				            'type'		=> 'ZO',
				            'id_player'		=> $id_player
				        );
				$result = $this->All_model->insertfileshands($sql_data);
				if(!$result)
				{
					log_message('error', 'Não conseguiu inserir o numnero do ficheiro (workfiles linha 287');
				}
			}
			//exec ("chmod 777 -R ".VAR_PATHCONVERTED);
		}
	}

	function convetHandPtReg($file_path,$id_player,$nick_original)
	{
		$array_nickname = $this->All_model->getallnickname();
		
		$file_read = file_get_contents($file_path);
		//echo $file_read;
		$new_file = "";
		$date_old = "";
		$qtd_hand = 0;
		
		if (strpos($file_read,"PokerStars") !== false) 
		{
			$p = true;
			$hand_old = false;
			$arr_file_read = explode("PokerStars",$file_read);
			
			//echo count($arr_file_read).' ';
			//print_r($arr_file_read);
			//ok ate aqui tenho hands
			
			for($m = 1;$m<count($arr_file_read);$m++)
			{
				$num_hand = 0;
				
				//echo $arr_file_read[$m].'             ';
				//echo $m;
				
				if($arr_file_read[$m] != "")
				{
					if(strpos($arr_file_read[$m],"Seat 9") === false)
					{
						//vou ler a primeira linha só
						//echo $arr_file_read[$m]. '            ';
						$str = strtok($arr_file_read[$m], "\r\n");
						//echo $str.'                      ';
						if(strpos($str,"Hold'em No Limit") !== false)
						{
							//limit hand
							//NLxx
							if($p)
							{
								$limit = getStringBetween($str,"(",")");
								$limit = str_replace(chr(0xE2).chr(0x82).chr(0xAC),"",$limit);
								$limit = str_replace(chr(128), '',$limit);
								$limit = str_replace("EUR","",$limit);
								$limit = str_replace(" ","",$limit);
								//echo $limit.'   ';
								$limit = findlimithand($limit);
								//echo $limit;
								//id limit DB
								$limit_temp = $this->All_model->getlimitbyname($limit);
								$limit_final = $limit_temp->id_limit;
							}
							//data
							$date_new = str_replace("/","-",getStringBetween($str,"- "," "));
							//só vou guardar 1 ano de hands
							//echo $date_new.'     ';
							//echo strtotime($date_new).'     ';
							//echo strtotime("now -1 year").'     ';
							if(strtotime($date_new) > strtotime("now -1 year"))
							{
								//numero da hand
								$num_hand = getStringBetween($str,"#",":");
								//meter na DB
								$sql_data = array(
								            'numhands'        	=> $num_hand,
								            'playerHH'		=> $id_player
								        );
								
								$result = $this->All_model->inserthandPtReg($sql_data,$num_hand);
								if(!$result)
								{
									log_message('error', 'Não conseguiu inserir a hand na DB ou duplicate');
								}else{
									//alterar o nick do player
									$new_nick = $array_nickname[rand(0,299)];
									$new_hand = str_replace($nick_original,$new_nick,$arr_file_read[$m]);
									//Criar o novo string da hand e meter na varíavel
									$new_file .= "PokerStars".$new_hand;
									//echo $new_file;
									$qtd_hand++;
								}
							}else{
								//echo 'aaaaaa';
								$hand_old = true;
							}
							$p = false;
						}else{
							//echo 'bbbbbbbbb';
							$hand_old = true;
						}
					}else{
						$hand_old = true;
					}
				}
				if($hand_old)
					break;
			}
			//echo $new_file;
			//acabei de ler o ficheiro
			//meter na DB (TBL_QTDHANDS e TBL_FILECONVERT) + na pasta de partilha para os gajos
			//TBL_QTDHANDS
			//antes de inserir ver se já existe algo do género na DB
			if(!$hand_old && $new_file != "")
			{
				$array_numhand = $this->All_model->numhands($id_player,$limit_final,$date_new);
				if($array_numhand)
				{
					//update
					$new_numhand = $array_numhand[0] + $qtd_hand;
					$sql_data = array(
					            'id_player'        	=> $id_player,
					            'id_limit'		=> $limit_final,
					            'date'		=> $date_new,
					            'qtd'		=> $new_numhand 
					        );
					$result = $this->All_model->updatenumhands($sql_data,$array_numhand[1]);
					if(!$result)
					{
						log_message('error', 'Não conseguiu fazer o update de num hands (workfiles linha 274');
					}
				}else{
					//insert
					$sql_data = array(
					            'id_player'        	=> $id_player,
					            'id_limit'		=> $limit_final,
					            'date'		=> $date_new,
					            'qtd'		=> $qtd_hand 
					        );
					$result = $this->All_model->insertnumhands($sql_data);
					if(!$result)
					{
						log_message('error', 'Não conseguiu inserir o numero de hands (workfiles linha 287');
					}
				}
				//TBL_FILECONVERT
				$today = todaysplit();
				//criar a pasta caso não existe
				if(!file_exists(VAR_PATHCONVERTED_PT_SH."/".$limit))
				{
					mkdir(VAR_PATHCONVERTED_PT_SH."/".$limit, 0777, true);						
				}
				if(!file_exists(VAR_PATHCONVERTED_PT_SH."/".$limit."/".$today[0]))
				{
					mkdir(VAR_PATHCONVERTED_PT_SH."/".$limit."/".$today[0], 0777, true);	
				}
				if(!file_exists(VAR_PATHCONVERTED_PT_SH."/".$limit."/".$today[0]."/".$today[1]))
				{
					mkdir(VAR_PATHCONVERTED_PT_SH."/".$limit."/".$today[0]."/".$today[1], 0777, true);
				}
				if(!file_exists(VAR_PATHCONVERTED_PT_SH."/".$limit."/".$today[0]."/".$today[1]."/".$today[2]))
				{
					mkdir(VAR_PATHCONVERTED_PT_SH."/".$limit."/".$today[0]."/".$today[1]."/".$today[2], 0777, true);
				}
				//criar o ficheiro de hands
				$namefile = $this->All_model->getlastnamefile($limit_final,$today[0],$today[1],$today[2]);
				$myfile = fopen(VAR_PATHCONVERTED_PT_SH."/".$limit."/".$today[0]."/".$today[1]."/".$today[2]."/".$namefile.".txt", "w");
				fwrite($myfile, $new_file);
				fclose($myfile);
				//meter na DB
				$sql_data = array(
				            'num_hands'        	=> $qtd_hand,
				            'id_limit'		=> $limit_final,
				            'year'		=> $today[0],
				            'month'		=> $today[1], 
				            'day'		=> $today[2],
				            'namefile'		=> $namefile,
				            'room'		=> 'PT',
				            'type'		=> 'SH',
				            'id_player'		=> $id_player
				        );
				$result = $this->All_model->insertfileshands($sql_data);
				if(!$result)
				{
					log_message('error', 'Não conseguiu inserir o numnero do ficheiro (workfiles linha 287');
				}
			}
			//exec ("chmod 777 -R ".VAR_PATHCONVERTED);
		}
	}
	
}