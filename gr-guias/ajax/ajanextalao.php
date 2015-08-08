<?php
include '../includes/allpageaj.php';

if(isset($_POST['tal_filename']))
{
    	$postfilename = $_POST['tal_filename'];
    	$postfilename = str_ireplace("\\", "/", $postfilename);
    	$file_new = explode("/", $postfilename);
    	foreach ($file_new as $v)
    	{
		if(strpos($v, ".") !== false)
		{
			$filefinal = explode(".", $v);
			$namefile = "";
			$extension = "";
			if(count($filefinal) > 2)
			{
				for($i=0 ;$i<(count($filefinal)-1) ;$i++)
				{
					$namefile .= $filefinal[$i] . " ";
					if(($i+1) == (count($filefinal)-1))
					{
						$extension .= $filefinal[($i+1)];
					}
				}
			}else{
				$namefile .= $filefinal[0] . "." . $filefinal[1];
				$extension .= $filefinal[1];
			}
			rename('../uploads/' . $v, '../uploads/' . $_POST['id_gr'] . '.' . $extension);
			//agora vou guardar isso na DB			
			$fields = array();
			$fields['id'] = $_POST['id_gr'];
			$fields['url_talao'] = dbString('uploads/' . $_POST['id_gr'] . '.' . $extension);
			grepUpdate($fields);
			unset($fields);
		}
	}   
}

insertmodifgr($_POST['id_gr'], "Anexo do Talão");

echo 'ok';

closeDataBase();
?>
