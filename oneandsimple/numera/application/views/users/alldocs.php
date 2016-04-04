<?php $this->load->view('header')?>
    <div class="section-right">
        <div class="headind">
          <h2><?php echo $title; ?></h2>
        </div>
        <div class="clear"><br/> <?php echo $this->session->flashdata('message'); ?></div>
        <?php //pre($user_folders_list);?>
        <?php //pre($visiblefolders);?>
        <?php //pre($user_files_list);?>



        <ul class="folder">
        <?php //echo 'visible folder : '.count($visiblefolders); ?>
        <?php //echo 'file_list : '.count($user_files_list); ?>        
        <?php if(count($visiblefolders)>0) {?>
        <?php //if(count($user_files_list)){ $i=0 ;}
        $isEmpty = 0;
        ?>

	
	<?php
		$folder_vis = array(); 
		foreach($visiblefolders as $k=>$folders) {
			$folder_vis[] = $folders['googlefolderId'];
			$folder_name_arry[$folders['googlefolderId']] = $folders['folderName'];
		}
	?>	

	<?php //foreach($visiblefolders as $k=>$folders) {?>
		<?php foreach($user_files_list as $fkey=>$googlefolders) {?>
                <!--for file-->
		   <?php //$totalF[]=$folder_name_arryfolderName']; ?>	        
			
                    <?php if(in_array($googlefolders->id,$folder_vis)){ ?>
                        <?php $newkey=$fkey;   ?>        
                        <?php if($folders[0]->Viewfolder=='accept'){ ?>
                            <?php
                                $isEmpty=1;
                                $getcount = count($user_files_list);
                            ?>
                                <li><a href="<?php echo base_url();?>users/fileListing/<?php echo $googlefolders->id; ?>"><img alt="" src="<?php echo base_url();?>images/all-docs-big.png"><p><?php echo $folder_name_arry[$googlefolders->id]; ?></p></a>
				    <?php //echo @$user_files_list[$newkey][0]->parents[0]->id; ?>
                                    <?php //echo $user_files_list[$user_folders_list[$fkey]] ?>
                                </li>
                        <?php } ?>
                    <?php } ?>
            <?php } ?>
            
        <?php //} ?>
            <?php if($isEmpty==0){ ?>
                    <div class="alert-info"><?php echo $this->lang->line('folder_empty_msg');?></div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert-error"><?php echo $this->lang->line('no_found_display');?></div>
        <?php } ?>
	<?php //echo count($totalF); ?>
        </ul>
    </div>
<?php $this->load->view('footer')?>
