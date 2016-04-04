<?php $this->load->view('admin_header')?>
	<div class="headind">
	     <h2><?php echo $title; ?></h2>
	     <?php if($this->uri->segment(3))
	       {
		    $cpid = $this->uri->segment(3);
	       } ?>
	       <span class="admin-right-menu">
		       <a href="<?php echo site_url();?>admin/managefolder/<?php echo $cpid?>">Add Folder </a>
	       </span>
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
					     
					?>
					<div class="stdListing">
				             <table width="100%" cellspacing="0" cellpadding="0" border="0">
						  <colgroup>
						       <col width="25">
						       <col width="250">
						       <col width="250">
						  </colgroup>
						  <tbody>
						  <tr>
							  <th scope="col"><a href="<?php echo site_url();?>admin/folderlist/<?php echo $cpid?>/orderby/folderName/<?php echo $orderby; ?>">Name</a></th>
							  <th scope="col"><a href="<?php echo site_url();?>admin/folderlist/<?php echo $cpid?>/orderby/clientName/<?php echo $orderby; ?>">Client Name</a></th>
							  <th scope="col">Actions</th>
						  </tr>
						  <?php //pre($folder_array);
						       $attributes = array('id' => 'listingForm', 'name' => 'listingForm');
						       echo form_open('admin/', $attributes);
						  ?>
						  
						  <?php if(count($folder_array)>1) { $i=0;?>
							  <?php //pre($userfolders) ; ?>
							  <?php //pre($folder_array); ?>
							  <?php foreach($folder_array as $key=>$folders) {
								 
							      
							       if ($i % 2 == 1) {
								   $class = "alternateRow";
							       } else {
								   $class = "";
							       }
							      ?>
							    <?php if($folders['parentId']!=0) {?>  
							    <tr class="<?php echo $class;?>">
								      <td scope="col">
									  <?php  echo  $userfolders[$folders['id']];?>
									   
									   <!--<?php if($folders['parentId']==0){?>
										<img src="<?php echo base_url(); ?>images/all-docs.png"/><br/><?php echo $folders['folderName']; ?>
									   <?php } elseif($folders['parentId']==$folders['id']) { ?>
										     -- nn &nbsp;<img src="<?php echo base_url(); ?>images/all-docs.png"/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $folders['folderName']; ?>
									   <?php } else { ?>
										 --&nbsp;<img src="<?php echo base_url(); ?>images/all-docs.png"/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $folders['folderName']; ?>
									   <?php } ?>-->
								      </td>
								      <td scope="col">
									   <?php echo $folders['clientName']; ?>
									   
								      </td>
								      <td scope="col">
									      <select class="selActions select" id="<?php echo $folders['id'];?>" name="selActions" style="width: auto">
										    <option value="">Actions</option>   
										    <option value="managefolder<?php //echo $cpid?>">Edit</option>
										<?php if($folders['parentId']!=0) {?>
										    <option value="deletefolder">Delete</option>
									       <?php } ?>
									       </select>
								      </td>
							  </tr>
							    <?php  } ?>

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
	       if(vale === "deletefolder")
	       {
		    var res=confirm("Are you sure? you want to delete this.");
	       }else if(vale === "managefolder"){
			 var atrrid = $(this).attr('id');
			 var valee = '/numera/admin/'+vale+'/'+atrrid;
			 var formurl = valee;
			 $("#listingForm").attr("action",formurl);
			 $("#listingForm").attr("method",'POST');
			 $("#listingForm").submit();
	       }
	       
		    if(vale!='' && res==true){
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