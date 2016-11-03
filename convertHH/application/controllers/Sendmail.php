<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendmail extends CI_Controller {
	
	
	public function mail($email,$dia,$file)
	{
		shell_exec("echo -e 'to: ".$email."\nsubject: Hands ".$dia." \r\n\r\n Link Hands: ".$file."\r\n\r\n The link is available for 7 days.\r\n\r\n Good Luck at the tables :)' | /usr/sbin/ssmtp ".$email." -F'HH Sharing'");			
	}
	
	public function zipfilesbyplayer()
	{
		$this->load->helper('myfunction_helper');
		$this->load->library('zip');
		
		//more compress
		$this->zip->compression_level = 9;
		
		$all_players = $this->All_model->getplayersenable();
		//menos um dia por ser as hands do dia anterior que o soft foi convertido
		//as 8h, 12h, 16h, 20h
		$arr_today = todaysplitlessoneday();
		
		//para acrescentar ao nome do zip
		$numzip = 1;
		
		$this->load->library('ftp');
		$config['hostname'] = FTP_URL;
		$config['username'] = FTP_USERNAME;
		$config['password'] = FTP_PASSWORD;
		//$config['debug'] = TRUE;
		
		foreach($all_players as $elem_allplayers)
		{
			if(strtotime("now") < strtotime($elem_allplayers['expire_date']) && $elem_allplayers['email'] != "")
			{
				//por aqui o ficheiro de varios limites para o jogador
				$arr_limit = array($elem_allplayers['limit_play'],$elem_allplayers['limit_play2'],$elem_allplayers['limit_play3']);
				
				for ($r = 0;$r<count($arr_limit);$r++)
				{
					$this->zip->clear_data();
					if($arr_limit[$r] != 15 && $arr_limit[$r] != 0)
					{
						$arr_filestozip = $this->All_model->getfilesconvertbynorid($elem_allplayers['id_player'],$arr_limit[$r],$arr_today);
						$limit_convertHH = $this->All_model->getlimitbyid($arr_limit[$r]);
						foreach($arr_filestozip as $elem_zip)
						{
							/*$this->zip->add_data(VAR_PATHCONVERTED."/".$limit_convertHH->name_limit."/".$arr_today[0]."/".$arr_today[1]."/".$arr_today[2]."/".$elem_zip['namefile'].".txt", $elem_zip['namefile']);*/
							$this->zip->read_file(VAR_PATHCONVERTED."/".$limit_convertHH->name_limit."/".$arr_today[0]."/".$arr_today[1]."/".$arr_today[2]."/".$elem_zip['namefile'].".txt");
						}
						$total_hands = $this->All_model->sumconvertbynorid($elem_allplayers['id_player'],$arr_limit[$r],$arr_today);
						if($total_hands == 0)
						{
							$this->mail($elem_allplayers['email'],$arr_today[2]."-".$arr_today[1]."-".$arr_today[0],"No hands today :(");
						}else{
							$zipfile = VAR_PATHCONVERTED."/".$limit_convertHH->name_limit."_".$arr_today[0]."_".$arr_today[1]."_".$arr_today[2]."_".$total_hands."_".$numzip.".zip";
							$this->zip->archive($zipfile);
							
							shell_exec("ftp-upload -h ".FTP_URL." -u ".FTP_USERNAME." --password ".FTP_PASSWORD." -d / ".$zipfile);
							
							$this->ftp->connect($config);
							$list = $this->ftp->list_files('/');
							$this->ftp->close();
							
							if(in_array($limit_convertHH->name_limit."_".$arr_today[0]."_".$arr_today[1]."_".$arr_today[2]."_".$total_hands."_".$numzip.".zip",$list))
							{
								shell_exec("rm -rf ".$zipfile);
								//se o upload foi feito vou enviar o mail
								$this->mail($elem_allplayers['email'],$arr_today[2]."-".$arr_today[1]."-".$arr_today[0],"http://".FTP_URL."/".$limit_convertHH->name_limit."_".$arr_today[0]."_".$arr_today[1]."_".$arr_today[2]."_".$total_hands."_".$numzip.".zip");
							}else{
								log_message('error', 'Não conseguiu realizar o upload do ficheiro: '.$zipfile);
							}
						}
					}
					$numzip++;
				}
			}
						
		}
		//por aqui a apagar os ficheiros antigos ftp
		deletefilesftp();
	}
	
	
}