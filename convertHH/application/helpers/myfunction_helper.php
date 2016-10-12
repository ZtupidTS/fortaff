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
?>