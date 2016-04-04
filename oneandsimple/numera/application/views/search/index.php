<?php $this->load->view('header')?>
<script type="application/x-javascript">
    $(document).ready(function(){
		    $('.searchfolders').click(function(){
			    //alert($(this).attr('id'));
			    //return false;
			    var frmid=$(this).attr('id');
			    $('#frm'+frmid).submit();
		       
		    });
		    
		       $('#showadvancsrch').change(function(){
			if(this.checked)
			    $('#advancesearchdiv').css("display","block");
			else
			    $('#advancesearchdiv').css("display","none");
		
		    });
		
	});
</script>

    <div class="section-right">
        <div class="headind">
          <h2><?php echo $title; ?></h2>
        </div>
        <?php if($checkedAdvance!='chacked')
		{ 
		    @$adsearch = "; display:none";
		    @$checkedtrue="";
		}
		else { @$adsearch = "; display:block";
		     @$checkedtrue=' checked="checked" ';
		    
		}
		//echo $checkedAdvance;
	?>
	 <form method="post" id="frontsearchform" action="<?php echo base_url() ?>search?post=search">
	    <div class="main-tab">
		    <div class="tab-content-left" style="padding-left: 0 <?php echo @$msearch;?> " id="basicsearchdiv" >
			    
				<!--Tab 1 For Add basic client information-->
				<ul class="tab-field">
					<li style="width: 74%;">
						<span><?php echo form_label($this->lang->line('front_search_label'), 'searchvalue','class="required"');?><em>*</em></span>
						<div class="input-divs">
							 <?php echo form_input('searchvalue', set_value('search'),'id="searchvalue" class="searchbox_text chngseachid" style="text-align:left;"');?>
							<?php echo form_error('searchvalue'); ?>
						</div>
					    
					</li>
				</ul>
		    </div>
	    </div>
	    <div class="tab-content-left_old" style="padding-left: 19px !important">
		<span style="font-size: 14px;"><input type="checkbox" name="checkedadvancesearch" <?php echo @$checkedtrue ;?>  id="showadvancsrch" value="advancesearch">&nbsp;<?php echo form_label($this->lang->line('front_advancesearch_label'), 'searchvalue','class="required"');?></span>
						
	    </div>	
	
	    <div class="tab-content-left" style="padding-left: 0; <?php echo @$adsearch; ?>" id="advancesearchdiv">
			    <!--Tab 1 For Add basic client information-->
			    <ul class="tab-field">
				   
				    <li style="width: 74%;">
					    <span><?php echo form_label($this->lang->line('front_search_includeword_label'), 'fullText','class="required"');?></span>
					    <div class="input-divs">
						     <?php echo form_input('fullText', set_value('search'),'id="fullText" class="fullText"');?>
						    <?php echo form_error('fullText'); ?>
					    </div>
					
				    </li>
				    <li style="width: 74%;" id="viewfolderlist">
					    <?php $folderarray=getviewfolderlist();?>
					    <?php //pre($folderarray); ?>
					     <span><?php echo form_label($this->lang->line('front_search_infolder_label'), 'searchonfolder','class="required"');?></span>
					    <div class="input-divs">
						     <select name="searchfolderid" id="searchfolderid" class="select" >
							<option value = "">-- <?php echo $this->lang->line('front_select_label') ?> --</option>
									<?php if(isset($folderarray)){
									    
									     foreach($folderarray as $val)
									     {?>
										  <option value = "<?php echo $val['googlefolderId']; ?>"><?php echo ucfirst($val['folderName']);?></option>
									     
									<?php } }?>
								   </select>
						    <?php echo form_error('searchvalue_advance'); ?>
					    </div>
					
				    </li>
				    <li style="width: 74%;">
					    <span><?php echo form_label($this->lang->line('front_search_bytype_label'), 'mimeType','class="required"');?></span>
					    <div class="input-divs">
						     <select name="searchfiletype" id="searchfiletype" class="select" >
							<option value = "">-- <?php echo $this->lang->line('front_select_label') ?> --</option>
							<option value = "application/octet-stream"><?php echo $this->lang->line('front_search_audio_label') ?></option><!--Audio-->
							<option value = "application/vnd.google-apps.video"><?php echo $this->lang->line('front_search_video_label') ?></option><!--Video-->
							<option value = "excel"><?php echo $this->lang->line('front_search_spreadsheet_label') ?></option><!--Excel-->
							<option value = "word"><?php echo $this->lang->line('front_search_document_label') ?></option><!--Word-->
							<option value = "powerpoint"><?php echo $this->lang->line('front_search_presentation_label') ?></option><!--Powerpoint-->
							<!--<option value = "application/vnd.google-apps.folder">Folder</option>-->
							<option value = "application/octet-stream"><?php echo $this->lang->line('front_search_pdf_label') ?></option> <!--PDF-->
							<option value = "application/vnd.google-apps.file"><?php echo $this->lang->line('front_search_file_label') ?></option>
							<!--<option value = "text/plain">text</option>-->
							
						     </select>
						    <?php echo form_error('mimeType'); ?>
					    </div>
					
				    </li>
			    </ul>
			     
	    </div><br/>
	    <div class="input-radio" style="float:left">
		<input type="submit" class="sign" id="advancsearch" value="<?php echo $this->lang->line('front_search_btn_label') ?>" name="advancesearch"/>   
	    </div>
	</form> 
	
        <ul class="folder">
        <?php if(isset($_GET['post'])) {?>
        <?php if(count($visiblefolders)>0 && count($searchparerntArray)>0) {?>
        <?php //foreach($searchparerntArray as $googlefolders) {?>
	<?php foreach($visiblefolders as $folders) {?>
                <?php if(in_array($folders['googlefolderId'],$searchparerntArray)){ ?>
                    <?php if(@$folders[0]->Viewfolder=='accept'){ //echo 'bijendra'; ?>
                        <form method="post" id="frm<?php echo $folders['googlefolderId']; ?>" action="<?php echo base_url();?>users/fileListing/<?php echo $folders['googlefolderId']; ?>?search=file">
                            <?php //if($googlefolders->mimeType=='application/vnd.google-apps.folder'){ ?>
                                <li><a href="javascript:void(0);" id="<?php echo $folders['googlefolderId']; ?>" class='searchfolders'><img alt="" src="<?php echo base_url();?>images/all-docs-big.png"><p><?php echo $folders['folderName']; ?></p></a></li>
                            <?php foreach($googlesearchfile as $filekey=>$fileids){ ?>
                                <input type="hidden" id="searchvalue" name="searchfileid[<?php echo $filekey;?>]" value="<?php echo $fileids?>"/>
                            <?php } ?>
                        </form>
                    <?php } ?>
                <?php } ?>
            <?php //}?>
        <?php } ?>
        <?php } else { ?>
            <div class="alert-error"><?php echo $this->lang->line('no_found_display');?></div>
        <?php } ?>        
        <?php } ?>
        </ul>
    </div>
<?php $this->load->view('footer')?>

