<?php $this->load->view('header')?>
   <script type="text/javascript" >
    function show_preview(download_link,preview_link){
        var option = download_link;
        var splitarrray = option.split("=");
        var filearray = splitarrray[1];
        var filearray = filearray.split("&");
        var fileid=filearray[0];
        //alert(fileid);
        //if(fileid!=""){
         //       $.get('<?php echo base_url();?>users/ajaxsavrfolder/'+fileid, function(data) {
          //     });
        //	}
        
        $("#preview_panel").attr("src",preview_link);
        $("#download_file").attr("href",download_link);
        $("#dlink").attr("value",download_link);
        $(".showfram").css("display","block");
        
        
        
    }  

function select_all(){
	$('.files').addClass('tabactive');
	count_selected();
}

function count_selected(){
	$("#count_selected,#count_selected_btm").html($('.tabactive').size());
}

	$(document).ready(function(){	

		$('.files').click(function(){
		 
			var dfileid= $(this).attr('id');
			 var downloadlink =$("#dlink"+dfileid).val(); 
			$("#dlink").val(downloadlink);
			if($(this).hasClass('tabactive')){

				$(this).removeClass('tabactive');
				 
			}
			else{
			    $(this).addClass('tabactive');
				
			}
			count_selected();
		});
		
		$('.deletefle').click(function(){
		  if (confirm("<?php echo $this->lang->line('delete_warning_mgs');?>")) {
			// your deletion code
			return true;
		    }
		    return false;
		});
		
                
	});
 


    
</script>
<style type="text/css">
.file-action li a{
	border:none !important;
	background:none !important;
	padding: 6px !important;

}
.file-action li{
 margin-bottom: 0px !important;
}

</style>
    <div class="section-right">
     
        <div class="headind">
            <h2><?php echo $title; ?></h2>
            <?php if($this->uri->segment(3)){ $parnt_folder=$this->uri->segment(3);} ?>
	    
	    <?php if(!isset($_GET['search'])) {?>
	      	<?php if(count($user_file_list)>0) {?>
		  <ul class="pagination">
		      <li> <?php echo $this->lang->line('front_search_document_label'); ?></li>
		      <li><a href="javascript:void(0);" id="count_selected">0</a></li>
		      <li> of</li>
		      <li>
			  <?php foreach($user_file_list as $folders) {?>
			      <?php if($folders->mimeType!='application/vnd.google-apps.folder'){?>
				      <?php  $totaldoc[]=$folders;?>
			      <?php } ?>
			  <?php } ?>
			  <a class="pageactive" href="<?php echo count(@$totaldoc); ?>"><?php echo count(@$totaldoc); ?></a>
		      </li>
		      <li><a href="javascript:void(0);" onclick="select_all();"><?php echo $this->lang->line('all_label'); ?></a></li>
		  </ul>
		  <?php } ?>
	   <?php  } ?>
        </div>
	<!--Check folder permsions-->
	<?php //pr($visiblefolders); ?>
	<?php foreach($visiblefolders as $checkfolder){
	       if($checkfolder['googlefolderId']==$this->uri->segment(3))
	       {
		 $usrpermissionArray['permisson']=$checkfolder[0];
	       }
	     }
	     
	     //pre($usrpermissionArray);
	 ?>
	
	
	<div class="clear"><br/> <?php echo $this->session->flashdata('message'); ?></div>
         <?php if(!isset($_GET['search'])) {?>
            <!--Folder List-->
	       <?php //pr($visiblefolders);?>
                <ul class="folder">
		  <?php foreach($visiblefolders as $viewfolders) {?>
		     <?php foreach($user_file_list as $folders) {?>
			<?php if($viewfolders['googlefolderId']==$folders->id){ ?>
			   <?php if($folders->mimeType=='application/vnd.google-apps.folder'){?>
			    <?php if(@$viewfolders[0]->Viewfolder=='accept'){ ?> 
			       <?php $folderhref = base_url().'users/fileListing/'.$folders->id ; ?>
			       <!--Folders list-->
			       <?php if($folders->mimeType=='application/vnd.google-apps.folder'){ ?>
				   <li><a  href="<?php echo $folderhref; ?>">
				       <div><img alt="" src="<?php echo base_url();?>images/all-docs-big.png"></div>
				       <?php echo ucfirst($folders->title); ?>
					   <!--<ul style="margin-left: 30px;"><li><br/>Export</li></ul>-->
				       </a>
				       
				   </li>
			       <?php } ?>
			    <?php } ?>   
			   <?php }?>
			<?php }?>	
		     <?php }?>
		  <?php }?>
                </ul>
        <?php } ?>
        
        <div class="tab-menu">
            <?php //pre($user_file_list); ?>
            <!--Search file list-->
            <?php if(isset($_GET['search'])) {?>
                <?php //pre($search_file_ids);?>
                    <ul class="tab">
		       <?php $totalsearch=count($search_file_ids);   ?>
                        <?php foreach($user_file_list as $folders) {?>
                            <?php foreach($search_file_ids as $searchfileids){?>
                                    <!--Files list-->
                                    <?php if($folders->mimeType!='application/vnd.google-apps.folder' && $searchfileids->id==$folders->id){?>
                                        <li><a  href="javascript:void(0);" class="files" id="<?php echo $folders->id;?>">
                                            <?php echo ucfirst($folders->title); ?>
                                        </a>
					<ul class="sub-menu file-action">
                                           <li><a title="<?php echo $this->lang->line('send_file_to_title');?>" style="color:#0E0E0E;font-size: 12px" class="" id="<?php echo $folders->id;?>" href="<?php echo base_url();?>users/composeMessage?fileid=<?php echo $folders->id;?>"><?php echo $this->lang->line('send_file_to_title');?></a></li> 
					   <li><a title="<?php echo $this->lang->line('preview_title');?>" style="color:#0E0E0E;font-size: 12px" class="preview_file cboxElement" id="<?php echo $folders->id;?>" href="#file_preview_form"><?php echo $this->lang->line('preview_label');?></a></li>
					   <li><a title="<?php echo $this->lang->line('viewfileinformation_title');?>" style="color:#0E0E0E;font-size: 12px" class="file_update cboxElement" id="<?php echo $folders->id;?>" href="#file_edit_form"><?php echo $this->lang->line('viewfileinformation_label');?></a></li>
					   <li><a title="<?php echo $this->lang->line('rename_title');?>" style="color:#0E0E0E;font-size: 12px" class="showrename cboxElement" id="<?php echo $folders->id;?>" href="#file_rename_form"><?php echo $this->lang->line('rename_label');?></a></li>
					   <?php foreach($usrpermissionArray as $fpermission){?>
					     <?php if(@$fpermission->moovefile=='accept') {?>
					      <li><a title="<?php echo $this->lang->line('movefile_title');?>" style="color:#0E0E0E;font-size: 12px" class="file_move cboxElement" id="<?php echo $folders->id;?>" href="#moov_file"><?php echo $this->lang->line('movefile_label');?></a></li>
					     <?php } ?>
					   <?php } ?>
					   <?php foreach($usrpermissionArray as $fpermission){?>
					     <?php if(@$fpermission->Deletefile=='accept') {?>
					       <li><a title="<?php echo $this->lang->line('deletefile_title');?>" style="color:#0E0E0E;font-size: 12px" id="<?php echo $folders->id;?>" class="deletefle" href="<?php echo base_url()?>users/deletegooglefile/<?php echo $parnt_folder; ?>/<?php echo $folders->id; ?>"><?php echo $this->lang->line('deletefile_label');?></a></li>
					   <?php } ?>
					   <?php } ?>
					   <li><a title="<?php echo $this->lang->line('downloadfile_title');?>" style="color:#0E0E0E;font-size: 12px" class="" href="<?php echo base_url()?>users/downloadFile_drive/<?php echo $folders->id; ?>"><?php echo $this->lang->line('downloadfile_label');?></a></li>
					 </ul>
                                </li>
					       <input type="hidden" id="dlink<?php echo $folders->id;?>" value="<?php echo $folders->webContentLink;?>"/>
                                        </li>
                                    <?php } ?>
                             <?php } ?>   
                            <?php //downloadUrl = file->getWebContentLink();?>
                        <?php } ?>
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                    </ul>
                    <div class="tab-content">
                        <div class="main-tab">
                           
                        </div>
			<?php if(isset($totalsearch)){ ?>
                        <div class="right-pagination">
                           <ul class="pagination">
				<li> <?php echo $this->lang->line('front_search_document_label'); ?></li>
				<li><a href="javascript:void(0);" id="count_selected">0</a></li>
				<li> of</li>
				<li>
				    <?php foreach($user_file_list as $folders) {?>
					<?php if($folders->mimeType!='application/vnd.google-apps.folder'){?>
						<?php  $totaldoc[]=$folders;?>
					<?php } ?>
				    <?php } ?>
				    <a class="pageactive" href="<?php echo count(@$totaldoc); ?>"><?php echo @$totalsearch; ?></a>
				</li>
				<li><a href="javascript:void(0);" onclick="select_all();"><?php echo $this->lang->line('all_label'); ?></a></li>
			    </ul>
                        </div
			<?php } ?>
                    </div>
		    
            <?php }else { ?>
                
            <!--Show all files -->
	    <!--add file permission array-->
	    <?php //if(!empty($usrpermissionArray)) {?> 
		 <?php //$user_file_list= array_merge($user_file_list,$usrpermissionArray) ?>
	    <?php //} ?>
	    <?php  //pre($user_file_list);?>
	    <?php  //pre($usrpermissionArray);?>

            <?php if(count($user_file_list)>0) {?>
                <ul class="tab">
                    <?php foreach($user_file_list as  $fkey=>$folders) {?>
                        <!--[mimeType] => application/vnd.google-apps.folder-->
			<?php //$folders[]= $usrpermissionArray ?>
                         <!--Folders list-->
                            <!--<?php if($folders->mimeType=='application/vnd.google-apps.folder'){?>
                                    <?php $folderhref = base_url().'users/fileListing/'.$folders->id ; ?>
                                    <?php if($folders->mimeType=='application/vnd.google-apps.folder'){ ?>
                                        <li><a  href="<?php echo $folderhref; ?>">
                                            <div><img alt="" src="<?php echo base_url();?>images/all-docs.png"></div>
                                            <?php echo ucfirst($folders->title); ?>
                                            </a>
                                        </li>
                                       
                                    <?php } ?>
                            <?php }?>-->
                            
                            <!--Files list-->
                            <?php if($folders->mimeType!='application/vnd.google-apps.folder'){?>
			    
                            <?php  $totalfile=count($user_file_list);?>
                                <li class="files_li">
				   <a  href="javascript:void(0);" class="files" id="<?php echo $folders->id;?>" >
                                    <?php echo ucfirst($folders->title); 
                                    //pre($folders);
                                    ?> 
                                   </a>
				    <ul class="sub-menu file-action">
				      <li><a title="<?php echo $this->lang->line('send_file_to_title');?>" style="color:#0E0E0E;font-size: 12px" class="" id="<?php echo $folders->id;?>" href="<?php echo base_url();?>users/composeMessage?fileid=<?php echo $folders->id;?>"><?php echo $this->lang->line('send_file_to_title');?></a></li>
				      <li><a title="<?php echo $this->lang->line('preview_title');?>" style="color:#0E0E0E;font-size: 12px" class="preview_file cboxElement" id="<?php echo $folders->id;?>" href="#file_preview_form"><?php echo $this->lang->line('preview_label');?></a></li>
				      <li><a title="<?php echo $this->lang->line('viewfileinformation_title');?>" style="color:#0E0E0E;font-size: 12px" class="file_update cboxElement" id="<?php echo $folders->id;?>" href="#file_edit_form"><?php echo $this->lang->line('viewfileinformation_label');?></a></li>
				      <li><a title="<?php echo $this->lang->line('rename_title');?>" style="color:#0E0E0E;font-size: 12px" class="showrename cboxElement" id="<?php echo $folders->id;?>" href="#file_rename_form"><?php echo $this->lang->line('rename_label');?></a></li>
				      <?php foreach($usrpermissionArray as $fpermission){?>
					<?php if(@$fpermission->moovefile=='accept') {?>
					 <li><a title="<?php echo $this->lang->line('movefile_title');?>" style="color:#0E0E0E;font-size: 12px" class="file_move cboxElement" id="<?php echo $folders->id;?>" href="#moov_file"><?php echo $this->lang->line('movefile_label');?></a></li>
					<?php } ?>
				      <?php } ?>
				      <?php foreach($usrpermissionArray as $fpermission){?>
					<?php if(@$fpermission->Deletefile=='accept') {?>
					  <li><a title="<?php echo $this->lang->line('deletefile_title');?>" style="color:#0E0E0E;font-size: 12px" id="<?php echo $folders->id;?>" class="deletefle" href="<?php echo base_url()?>users/deletegooglefile/<?php echo $parnt_folder; ?>/<?php echo $folders->id; ?>"><?php echo $this->lang->line('deletefile_label');?></a></li>
				      <?php } ?>
				      <?php } ?>
				      <li><a title="<?php echo $this->lang->line('downloadfile_title');?>" style="color:#0E0E0E;font-size: 12px" class="" href="<?php echo base_url()?>users/downloadFile_drive/<?php echo $folders->id; ?>"><?php echo $this->lang->line('downloadfile_label');?></a></li>
				    </ul>
                                </li>
				<input type="hidden" id="dlink<?php echo $folders->id;?>" value="<?php echo $folders->webContentLink;?>"/>
                            <?php } ?>
                            
                        <?php //downloadUrl = file->getWebContentLink();?>
                    <?php } ?>
                </ul>
             <?php if(isset($totalfile)){?>
            <div class="tab-content">
                <div class="main-tab showfram" style="display:none">
                    <div class="tab-content-right" style="width:93% "> <h1 class="title">Preview</h1>
                       <br/> <a id="download_file" href="javascript:void(0);" title="Click here to download a file">Download</a>
                       <br/>
                       <iframe src="" id="preview_panel" width="400" height="400"></iframe>
                        <!--<img src="<?php echo base_url();?>images/pic.png" alt="" />-->
                    </div>
                </div>
                <div class="right-pagination showfram" style="display:none">
                    <ul class="pagination">
                        <li> <?php echo $this->lang->line('front_search_document_label'); ?></li>
                        <li><a href="javascript:void(0);" id="count_selected_btm">0</a></li>
                        <li> of</li>
                        <li><a class="pageactive" href="<?php echo count($totaldoc); ?>"><?php echo count($totaldoc); ?></a></li>
                        <li><a href="javascript:void(0);" onclick="select_all();"><?php echo $this->lang->line('all_label'); ?></a></li>
                    </ul>
                </div>
            </div>
            <?php } ?>
            <?php } else {?>
                <div class="alert-error"><?php echo $this->lang->line('no_found_display');?></div>
            <?php } ?>
        
            <?php } ?>
            <input type="hidden" name="fieldvalue" id="fieldid" value="" />
            <input type="hidden" name="dlink" id="dlink" value="" />
	    
	    <!--Old parent folder-->
	    <input type="hidden" name="oldparentfolderid" id="oldparentfolderid" value="<?php echo $parnt_folder; ?>" />
        </div>
    </div>
    <?php if(isset($_GET['preview'])) {?>
	<script type="text/javascript">
	function loadiframe(){
	    //alert("ok");
	}    
       </script>
       <iframe src="http://docs.google.com/viewer?url=<?php echo urlencode(base_url().'uploads/'.$file_name);?>&embedded=true" width="600" height="780" style="border: none;" onload="loadiframe();"></iframe>
    <?php } ?>  
<?php $this->load->view('footer')?>
