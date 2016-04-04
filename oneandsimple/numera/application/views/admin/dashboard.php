<?php $this->load->view('admin_header')?>
	<div class="headind">
	     <h2>Welcome to Administrator</h2>
	</div>
	<div class="tab-menu" style="height: 450px;">
		<div class="tab-content">
			<br/>
			<div class="main-tab">
				<div class="tab-menu" style="margin-top:50px;margin-left: 60px;">
					<ul class="tab">
					  <li><a href="<?php echo base_url();?>admin/users" class="tabactive"><div> Total Number Users (<?php echo $users['noofuser'] ?>)</div></a></li>
					  <li><a href="<?php echo base_url();?>admin/clients">Total Number Clients(<?php echo $users['noofclint'] ?>)</a></li>
					  <!--<li class=""><a href="#">Teste google docs 2</a></li>-->
					</ul>
				</div>
	</div>
<?php $this->load->view('admin_footer')?>
