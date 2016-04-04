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
		  if (confirm("Are you sure? you want to delete this file")) {
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
            <?php if(count($recentfilelist)>0) {?>
		  <ul class="pagination">
		      <li> Document</li>
		      <li><a href="javascript:void(0);" id="count_selected">0</a></li>
		      <li> of</li>
		      <li>
			  <?php foreach($recentfilelist as $folders) {?>
				      <?php  $totaldoc[]=$folders;?>
			  <?php } ?>
			  <a class="pageactive" href="<?php echo count(@$totaldoc); ?>"><?php echo count(@$totaldoc); ?></a>
		      </li>
		      <li><a href="javascript:void(0);" onclick="select_all();">All</a></li>
		  </ul>
		  <?php } ?>
        </div>
	<div class="clear"><br/> <?php echo $this->session->flashdata('message'); ?></div>
         
        <div class="tab-menu">
            <?php //pre($recentfilelist); ?>
            
            <!--Check folder permsions-->
	<?php //pre($recentfilelist); ?>
	<?php foreach($visiblefolders as $checkfolder){
	       if($checkfolder['googlefolderId']==$this->uri->segment(3))
	       {
		 $usrpermissionArray['permisson']=$checkfolder[0];
	       }
	     }
	     
	     //pre($user_folders_list);
	 ?>
            
            <?php if(count($recentfilelist)>0) {?>
                    <ul class="tab">
                        <?php foreach($recentfilelist as  $fkey=>$files) {?>
			   <?php //foreach($user_folders_list as  $googlefiles) {?>
			     <?php //if($googlefiles->id == $files['doc_id']) { ?>
				   <?php  $totalfile=count($recentfilelist);?>
                                    <li class="files_li">
                                       <a  href="javascript:void(0);" class="files" id="<?php echo $files['doc_id'];?>" >
                                        <?php echo ucfirst($files['title']); ?> 
                                       </a>
                                        <ul class="sub-menu file-action">
					 <?php if($files['action_description']!='Delete file') { ?>
                                          <li><a title="<?php echo $this->lang->line('preview_title');?>" style="color:#0E0E0E;font-size: 12px" class="preview_file cboxElement" id="<?php echo $files['doc_id'];?>" href="#file_preview_form"><?php echo $this->lang->line('preview_label');?></a></li>
                                          <li><a title="<?php echo $this->lang->line('viewfileinformation_title');?>" style="color:#0E0E0E;font-size: 12px" class="file_update cboxElement" id="<?php echo $files['doc_id'];?>" href="#file_edit_form"><?php echo $this->lang->line('viewfileinformation_label');?></a></li>
                                          <li><a title="<?php echo $this->lang->line('rename_title');?>" style="color:#0E0E0E;font-size: 12px" class="showrename cboxElement" id="<?php echo $files['doc_id'];?>" href="#file_rename_form"><?php echo $this->lang->line('rename_label');?></a></li>
                                          <?php foreach($usrpermissionArray as $fpermission){?>
                                            <?php if(@$fpermission->moovefile=='accept') {?>
                                             <li><a title="<?php echo $this->lang->line('movefile_title');?>" style="color:#0E0E0E;font-size: 12px" class="file_move cboxElement" id="<?php echo $files['doc_id'];?>" href="#moov_file"><?php echo $this->lang->line('movefile_label');?></a></li>
                                            <?php } ?>
                                          <?php } ?>
                                          <?php foreach($usrpermissionArray as $fpermission){?>
                                            <?php if(@$fpermission->Deletefile=='accept') {?>
                                              <li><a title="<?php echo $this->lang->line('deletefile_title');?>" style="color:#0E0E0E;font-size: 12px" id="<?php echo $files['doc_id'];?>" class="deletefle" href="<?php echo base_url()?>users/deletegooglefile/<?php echo $parnt_folder; ?>/<?php echo $files['doc_id']; ?>"><?php echo $this->lang->line('deletefile_label');?></a></li>
                                          <?php } ?>
                                          <?php } ?>
                                          <li><a title="<?php echo $this->lang->line('downloadfile_title');?>" style="color:#0E0E0E;font-size: 12px" class="" href="<?php echo base_url()?>users/downloadFile_drive/<?php echo $files['doc_id']; ?>"><?php echo $this->lang->line('downloadfile_label');?></a></li>
					  <?php } else { ?>
					   <li><a title="<?php echo $this->lang->line('deleted_file_title');?>" style="color:#0E0E0E;font-size: 12px"   href="javascript:void(0);"><?php echo $this->lang->line('deleted_file_byuser_label');?></a></li>
					  <?php } ?>
                                        </ul>
                                    </li>
			    <?php //} ?>	      
			  <?php //} ?>	    
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
                                           <li> Document</li>
                                           <li><a href="javascript:void(0);" id="count_selected_btm">0</a></li>
                                           <li> of</li>
                                           <li><a class="pageactive" href="<?php echo count($totalfile); ?>"><?php echo count($totalfile); ?></a></li>
                                           <li><a href="javascript:void(0);" onclick="select_all();">All</a></li>
                                       </ul>
                                   </div>
                           </div>
                   <?php } ?>
        <?php   } else {?>
                    <div class="alert-error"><?php echo $this->lang->line('no_found_display');?></div>
                  <?php } ?>
            <input type="hidden" name="fieldvalue" id="fieldid" value="" />
            <input type="hidden" name="dlink" id="dlink" value="" />
	    
        </div><?php echo $links; ?>
    </div>
<?php $this->load->view('footer')?>
