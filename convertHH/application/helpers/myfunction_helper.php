<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function dirSize($directory) 
{
	$size = 0;
	foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
	$size+=$file->getSize();
	}
	return $size;
}

function findlimithand($limit)
{
	switch ($limit) {
	    case "$0.01/$0.02":
	        return "NL2";
	        break;
	    case "$0.02/$0.05":
	        return "NL5";
	        break;
	    case "$0.05/$0.10":
	        return "NL10";
	        break;
	    case "$0.08/$0.16":
	        return "NL16";
	        break;
	    case "$0.10/$0.20":
	        return "NL20";
	        break;
	    case "$0.10/$0.25":
	        return "NL25";
	        break;
	    case "$0.15/$0.30":
	        return "NL30";
	        break;
	    case "$0.25/$0.50":
	        return "NL50";
	        break;
	    case "$0.50/$1.00":
	        return "NL100";
	        break;
	    case "$1/$2":
	        return "NL200";
	        break;
	    case "$2/$4":
	        return "NL400";
	        break;
	    case "$2.5/$5.00":
	        return "NL500";
	        break;
	    case "$0.01/$0.02 USD":
	        return "NL2";
	        break;
	    case "$0.02/$0.05 USD":
	        return "NL5";
	        break;
	    case "$0.05/$0.10 USD":
	        return "NL10";
	        break;
	    case "$0.08/$0.16 USD":
	        return "NL16";
	        break;
	    case "$0.10/$0.20 USD":
	        return "NL20";
	        break;
	    case "$0.10/$0.25 USD":
	        return "NL25";
	        break;
	    case "$0.15/$0.30 USD":
	        return "NL30";
	        break;
	    case "$0.25/$0.50 USD":
	        return "NL50";
	        break;
	    case "$0.50/$1.00 USD":
	        return "NL100";
	        break;
	    case "$1/$2":
	        return "NL200 USD";
	        break;
	    case "$2/$4":
	        return "NL400 USD";
	        break;
	    case "$2.5/$5.00 USD":
	        return "NL500";
	        break;
	    case "€0.01/€0.02":
	        return "NL2";
	        break;
	    case "€0.02/€0.05":
	        return "NL5";
	        break;
	    case "€0.05/€0.10":
	        return "NL10";
	        break;
	    case "€0.08/€0.16":
	        return "NL16";
	        break;
	    case "€0.10/€0.20":
	        return "NL20";
	        break;
	    case "€0.10/€0.25":
	        return "NL25";
	        break;
	    case "€0.15/€0.30":
	        return "NL30";
	        break;
	    case "€0.25/€0.50":
	        return "NL50";
	        break;
	    case "€0.50/€1.00":
	        return "NL100";
	        break;
	    case "€1/€2":
	        return "NL200";
	        break;
	    case "€2/€4":
	        return "NL400";
	        break;
	    case "€2.5/€5.00":
	        return "NL500";
	        break;
	    default:
	        return "N/A";
	        break;
	}
}

function getStringBetween($str,$from,$to)
{
    $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
    return substr($sub,0,strpos($sub,$to));
}

function todaysplit()
{
	$today = explode("-",date("Y-m-d"));
	return $today;
}

function todaysplitlessoneday()
{
	$today = explode("-",date("Y-m-d", time() - 86400));
	/*$today = explode("-",date("Y-m-d", time()));*/
	return $today;
}

function todaysplitlessxday($lessday)
{
	$new_lessday = 86400 * $lessday;
	$today = explode("-",date("Y-m-d", time() - $new_lessday));
	return $today;
}

function deletefilesftp()
{
	$host = FTP_URL; //Replace with your host
	$username = FTP_USERNAME; //Replace with your username
	$password = FTP_PASSWORD; //Replace with your password
	$mode = "passive"; //Leave blank to go to active mode
	$dir = "/"; //Put the name of the directory in here where you want to loop through files, put / for root directory
	$daysOld = '7'; //Enter the age of files in days, if a file should be deleted that's older than 2 days enter 2
	$filesToSkip = array('.','..','.htaccess','index.html'); //Contains the files that the script needs to skip if it comes accross them
	$notificationEmail = 'stoploss59@gmail.com'; //The email address to send a notification when file fails to delete
	 
	//FTP session starting
	$connection = ftp_connect($host);
	$login = ftp_login($connection,$username,$password);
	 
	if(!$connection || !$login){ 
	    die('Connection attempt failed!');
	}
	 
	if($mode == 'passive'){
	    //Switching to passive mode
	    ftp_pasv($connection,TRUE);
	}else{
	    ftp_pasv($connection,FALSE);
	}
	 
	//Calcuting the datetime of todays day minus the amount of 2days entered
	$dateToCompare = date('Y-m-d',  strtotime('-'.$daysOld.' days',time()));
	 
	//Looping through the contents of the provided directory
	$files = ftp_nlist($connection,$dir); //ftp_rawlist — Returns a detailed list of files in the given directory
	 
	foreach($files as $file)
	{
	     //Check if the file is in the list of files to skip, if it is we continue the loop
	     if(in_array($file, $filesToSkip)){
	         continue;
	     }
	 
	     
	     $modTime = ftp_mdtm($connection, $file);
	     if(strtotime($dateToCompare) >= $modTime){
	         if(!ftp_delete($connection,$file)){ //Deleting the file that needs to be deleted
	             //If the file fails to delete we send a mail to the administrator
	             mail($notificationEmail, 'FAILED TO DELETE FILE', 'FAILED TO DELETE FILE: '.$file);
	        }
	    }
	}
	ftp_close($connection);
}

function uploadfilesftp($file,$remotefile)
{
	$connection = ftp_connect(FTP_URL);
	$login = ftp_login($connection,FTP_USERNAME,FTP_PASSWORD);
	
	if (ftp_put($connection, $remotefile, $file, FTP_ASCII)) {
		shell_exec("sleep 30");
		ftp_close($connection);
		return true;
	} else {
		ftp_close($connection);
		return false;
	}	
}
?>