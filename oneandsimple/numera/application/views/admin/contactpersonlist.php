<?php $this->load->view('admin_header')?>
	<div class="headind">
	     <h2><?php echo $title; ?></h2>
	</div>
	<div class="tab-menu">		
		<div class="tab-content"></br>
			<?php echo $this->session->flashdata('message'); ?>
			<br/>
			<div class="main-tab">
				   <div class="tab-content-left-table">
					<?php 
					     if($this->uri->segment(6)){
						if($this->uri->segment(6)=='desc'){
						     $orderby='asc';
						}else{ $orderby='desc';}
					     }else{ $orderby='desc';}
					     
					     if($this->uri->segment(3)){
						  $cpid = $this->uri->segment(3);
					     }
					?>
					<div class="stdListing">
				             <table width="100%" cellspacing="0" cellpadding="0" border="0">
						  <colgroup>
						       <col width="25">
						       <col width="250">
						       <col width="300">
						       <col width="150">
						       <col width="125">
						       <col width="80">		  
						       <col width="90">
						  </colgroup>
						  <tbody>
						  <tr>
							  <th scope="col" colspan="6">
								      <form method="post" id="searchform">Search Client by
								      
									      <select name="searchby" class="select" style="width: auto">
										      <option value="name">Name</option>
										      <option value="email">Email</option>
										      <option value="profession">Profession</option>
										      <option value="phone">Phone</option>
									      </select>
									      <?php echo form_input('searchvalue', set_value('search'),'id="searchvalue" class="searchbox_text"');?>
									      <?php echo form_error('searchvalue'); ?>
									      <input type="submit" value="Search" class="sign"  name="clientsearch"/>
								      </form>
							  </th>
							  <th>
								      <a href="<?php echo site_url();?>admin/managecontactperson/<?php echo $this->uri->segment(3);?>" style="float:right">Add contact person</a>
								 </th>
						  </tr>						
						  <tr>
							  <th scope="col"> <!--<a href="#" id="selectAll">All</a><a href="#" id="selectNone">None</a> -->select</th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/contactperson/<?php echo $cpid ;?>/orderby/name/<?php echo $orderby; ?>">Name</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/contactperson/<?php echo $cpid ;?>/orderby/profession/<?php echo $orderby; ?>">Profession</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/contactperson/<?php echo $cpid ;?>/orderby/email/<?php echo $orderby; ?>">Email</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/contactperson/<?php echo $cpid ;?>/orderby/phone/<?php echo $orderby; ?>">phone</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/contactperson/<?php echo $cpid ;?>/orderby/createDate/<?php echo $orderby; ?>">Register Date</a></th>
							  <th scope="col">Actions</th>
						  </tr>
						  <?php
						       $attributes = array('id' => 'listingForm', 'name' => 'listingForm');
						       echo form_open('admin/', $attributes);
						  ?>
						  
						  <?php if(count($contacpersonList )>0) { $i=0;?>
							  <?php foreach($contacpersonList as $contactperson_list) {
							      
							       if ($i % 2 == 1) {
								   $class = "alternateRow";
							       } else {
								   $class = "";
							       }
							      ?>
							    <tr class="<?php echo $class;?>">
								      <td scope="col"><input type="checkbox" value="<?php echo $contactperson_list['id'] ?>" class="checkbox selectRow" name="chkBox[]"  id="check"/></td>
								      <td scope="col"><?php echo $contactperson_list['name']; ?></td>
								      <td scope="col"><?php echo $contactperson_list['profession']; ?></td>
								      <td scope="col"><?php echo $contactperson_list['email']; ?></td>
								      <td scope="col"><?php echo $contactperson_list['phone']; ?></td>
								      <td scope="col"><?php echo $contactperson_list['createDate']; ?></td>
								      <td scope="col">
									      <select class="selActions select" id="<?php echo $contactperson_list['id'];?>" name="selActions" style="width: auto">
										    <option value="">Actions</option>   
										    <option value="managecontactperson/<?php echo $cpid?>">Edit</option>
										    <option value="contactpersondelete/<?php echo $cpid?>"">Delete</option>
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
	       /*For delete only*/
	       var valarray = vale.split('/');
	       if(valarray[0] === "contactpersondelete")
	       {
		    return confirm("Are you sure? you want to delete this.");
	       }
		    if(vale!=''){
			 var atrrid = $(this).attr('id');
			 var valee = '/numera/admin/'+vale+'/'+atrrid;
			 var formurl = valee;
			 $("#listingForm").attr("action",formurl);
			 $("#listingForm").attr("method",'POST');
			 $("#listingForm").submit();
			 return true
		    }
		});
	  
	  </script>
<?php $this->load->view('admin_footer')?>