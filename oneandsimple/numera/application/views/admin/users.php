<?php $this->load->view('admin_header')?>

	<div class="headind">
	     <h2><?php echo $title; ?></h2>
	       <span class="admin-right-menu">
			      <!--<a href="<?php echo site_url();?>admin/adduser">Add User </a><a > | </a>-->
			    <!--  <a href="<?php echo site_url();?>admin/clientservices">Client Services </a><a > | </a>-->
			      <a href="<?php echo site_url();?>admin/adduser">Add User</a>
	       </span>
	</div>
	
	<div class="tab-menu">		
		<div class="tab-content"></br>
			<?php echo $this->session->flashdata('message'); ?>
			<br/>
			<div class="main-tab">
				   <div class="tab-content-left-table">
					<?php 
					     if($this->uri->segment(5)){
						if($this->uri->segment(5)=='desc'){
						     $orderby='asc';
						}else{ $orderby='desc';}
					     }else{ $orderby='desc';}
					?>
					<div class="stdListing">
				             <table width="100%" cellspacing="0" cellpadding="0" border="0">
						  <colgroup>
						       <col width="25">
						       <col width="180">
						       <col width="300">
						       <col width="250">
						       <col width="95">
						       <col width="100">		  
						       <col width="250">
						  </colgroup>
						  <tbody>
						  <tr>
							  <th scope="col" colspan="8">
								  <form method="post" id="searchform">Search users by
									  <select name="searchby" class="select" style="width:auto">
										  <option value="udetails.fname">User Name</option>
										  <option value="usr.userEmail">Email</option>
										  <option value="udetails.clientId">Clien Name</option>
										  <option value="usr.userStatus">Status</option>
									  </select>
									  <?php echo form_input('searchvalue', set_value('search'),'id="searchvalue" class="searchbox_text"');?>
									  <?php echo form_error('searchvalue'); ?>
										<input type="submit" class="sign" value="Search" name="clientsearch">
									  <!--<input type="submit" value="Search" name="clientsearch"/>-->
								  </form>
							  </th>
						  </tr>						
						  <tr>
							  <th scope="col"> <!--<a href="#" id="selectAll">All</a><a href="#" id="selectNone">None</a> -->#</th>
							  <th scope="col">Image</th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/users/orderby/usr.userName/<?php echo $orderby; ?>">Full Name</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/users/orderby/clientId/<?php echo $orderby; ?>">Under the Client</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/users/orderby/userEmail/<?php echo $orderby; ?>">Email</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/users/orderby/userStatus/<?php echo $orderby; ?>">Status</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/users/orderby/userCreateDate/<?php echo $orderby; ?>">Register Date</a></th>
							  <th scope="col">Actions</th>
						  </tr>
						  <?php //pr($results);
						       $attributes = array('id' => 'listingForm', 'name' => 'listingForm');
						       echo form_open('admin/', $attributes);
						  ?>
						  
						  <?php	if(count($results )>0) { $i=0;?>
							  <?php foreach($results as $clist) {
							      
							       if ($i % 2 == 1) {
								   $class = "alternateRow";
							       } else {
								   $class = "";
							       }
							      
							      ?>
							  
							    <tr class="<?php echo $class;?>">
								  <td scope="col"><input type="checkbox" value="<?php echo $clist['id'] ?>" class="checkbox selectRow" name="chkBox[]"  id="check"/></td>
								  <td scope="col"><img src="<?php echo site_url().'uploads/users/'.$clist['userImage'];?>" style="width:100px;hieght:100px" name="<?php echo $clist['id'] ?>" title="<?php echo $clist['usrlgn_name'] ?>"></td>
								  <td scope="col"><?php echo ucfirst($clist['fname'].' '.$clist['lname']); ?></td>
								  <td scope="col"><?php echo ucfirst($clist['clientName']); echo ' ('.$clist['clientemail'].')';?></td>
								  <td scope="col"><?php echo $clist['userEmail']; ?></td>
								  <td scope="col">
								      <?php if($clist['userStatus']=='active') {?>
									   <img src="<?php echo site_url()?>images/icons/green_active.png" style="margin-left:10px" title="Active">
								      <?php } else {?>
									   <img src="<?php echo site_url()?>images/icons/red_inactive.png" style="margin-left:10px" title="Inactive">
								      <?php }?>
								  </td>
								  <td scope="col"><?php echo $clist['userCreateDate']; ?></td>
								  <td scope="col">
									  <select class="selActions select" id="<?php echo $clist['id'];?>" name="selActions" style="width: auto">
										<option value="">Actions</option>   
										<option value="adduser/<?php echo $clist['userId'];?>">Edit</option>
										<option value="active">Activate</option>
										<option value="inactive">Inactivate</option>
										<option value="delete">Delete</option>
									   </select>
								  </td>
							  </tr>
							  
							  <?php  } ?>
							  <?php echo form_close(); ?>
						  <?php } else {?>
						  <tr>
							  <td scope="col" colspan="7"><div class="alert-error">No result found to be display here.</div></td>
							  
						  </tr>
						  <?php } ?>
						  
						  </tbody>
					     </table><br/>
						  <?php echo $links; ?>
					</div>					
				   </div>
			</div>
		 
		</div>
	</div>
	  <script type="text/javascript">
	 $('.selActions').change(function() {
			var vale = $(this).val();
			var atrrid = $(this).attr('id');
			var valee = '/numera/admin/'+vale+'/'+atrrid;
			var formurl = valee;
			$("#listingForm").attr("action",formurl);
			$("#listingForm").attr("method",'POST');
			
			if(vale==='delete')
			{
			      var msg= confirm("Are you sure? you want to delete this.");
			      if(msg == true) {
				   $("#listingForm").submit();
				   return true   
			      }else{
				   return false;   
			      }
			}else{
			      $("#listingForm").submit();
			      return true   
			}
		});
	
	  </script>
<?php $this->load->view('admin_footer')?>