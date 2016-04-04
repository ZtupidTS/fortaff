<?php $this->load->view('admin_header')?>
	<div class="headind">
	     <h2><?php echo $title; ?></h2>
	       <span class="admin-right-menu">
			      <a href="<?php echo site_url();?>admin/clientservices">Client Services </a><a > | </a>
			      <a href="<?php echo site_url();?>admin/addclient">Add Client</a>
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
								  
									  <select name="searchby">
										  <option value="userName">Name</option>
										  <option value="serviceName">Service</option>
									  </select>
									  <?php echo form_input('searchvalue', set_value('search'),'id="searchvalue"');?>
									  <?php echo form_error('searchvalue'); ?>
									  <input type="submit" value="Search" name="clientsearch"/>
								  </form>
							  </th>
							  
							  <th scope="col"></th>
						  </tr>						
						  <tr>
							  <th scope="col"> <!--<a href="#" id="selectAll">All</a><a href="#" id="selectNone">None</a> -->select</th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/clientservices/orderby/clientId/<?php echo $orderby; ?>">Client Name</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/clientservices/orderby/serviceName/<?php echo $orderby; ?>">Service Name</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/clientservices/orderby/serviceDescription/<?php echo $orderby; ?>">Description</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/clientservices/orderby/startingDate/<?php echo $orderby; ?>">Starting Date</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/clientservices/orderby/endingDate/<?php echo $orderby; ?>">Ending Date</a></th>
							  <th scope="col">Actions</th>
						  </tr>
						  <?php
						       $attributes = array('id' => 'clienservices', 'name' => 'clienservices');
						       echo form_open('admin/', $attributes);
						       //pr($results);
						  ?>
						  
						  <?php if(count(@$results)>0) { $i=0;?>
							  <?php foreach($results as $clist) {
							      
							       if ($i % 2 == 1) {
								   $class = "alternateRow";
							       } else {
								   $class = "";
							       }
							      
							      ?>
							  
							    <tr class="<?php echo $class;?>">
								  <td scope="col"><input type="checkbox" value="<?php echo $clist['id'] ?>" class="checkbox selectRow" name="chkBox[]"  id="check"/></td>
								  <td scope="col"><a href="<?php echo site_url();?>admin/clientservices/<?php echo $clist['clientId']; ?>/notall"><?php echo $clist['userName']; ?></a></td>
								  <td scope="col"><?php echo $clist['serviceName']; ?></td>
								  <td scope="col"><?php echo word_wrap($clist['serviceDescription'], 76);
								  
									   	 //echo wordwrap($clist['serviceDescription'], 20, "\n", true);	  
								  ?></td>
								  <td scope="col"><?php echo $clist['startingDate']; ?></td>
								  <td scope="col"><?php echo $clist['endingDate']; ?></td>
								  <td scope="col">
									  <select class="selActions" id="<?php echo $clist['id'];?>" name="selActions">
										<option value="">Actions</option>   
										<option value="manageclientservice/<?php echo $clist['usrid'];?>">Edit</option>
										<option value="cservicedelete/<?php echo $clist['clientId'];?>">Delete</option>
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
					     </table>
						  <br/><?php echo @$links; ?>
					</div>					
				   </div>
			</div>
		 
		</div>
	</div>
	  <script type="text/javascript">
	 $('.selActions').change(function() {
			var vale = $(this).val();
			var atrrid = $(this).attr('id');
			
			var valarray = vale.split('/');
			if(valarray[0]=="cservicedelete")
			{
			   var msg= confirm("Are you sure? you want to delete this.");
			   
			}else {
			      var valee = '/numera/admin/'+vale+'/'+atrrid;
			      var formurl = valee;
			      $("#clienservices").attr("action",formurl);
			      $("#clienservices").attr("method",'POST');
			      $("#clienservices").submit();
			      return true
			}
			if(msg==true)
			{
			 var valee = '/numera/admin/'+vale+'/'+atrrid;
			 var formurl = valee;
			 $("#clienservices").attr("action",formurl);
			 $("#clienservices").attr("method",'POST');
			 $("#clienservices").submit();
			 return true
			}else { return false;}
		});
	
	  </script>
<?php $this->load->view('admin_footer')?>