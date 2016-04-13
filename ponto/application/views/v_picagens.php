<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($this->session->userdata('level') == 2)
{
	$this->load->view('template/header_admin');
	$this->load->view('template/footer_admin');
}else{
	$this->load->view('template/header_user');
	$this->load->view('template/footer_user');
}
?>

<?php

echo $id;
echo $data;
?>