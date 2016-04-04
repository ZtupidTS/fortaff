<script type="text/javascript">
    function loadiframe(filename){
        //alert($("#iframe").attr("name"));
       // var option=$("#iframe").attr("name");
         //   $.get('<?php echo base_url();?>users/delete_preview_file/'+option, function(data) {
       // });
        //alert("ok");
        
    }
    
</script>
<?php if($type=="image/jpeg") {?>
    <img src="<?php echo base_url().'uploads/'.$file_name;?>" style="text-align: center" onload="loadiframe();" id="iframe" name="<?php echo $file_name; ?>"/>
<?php } else { ?>
    <iframe src="http://docs.google.com/viewer?url=<?php echo urlencode(base_url().'uploads/'.$file_name);?>&embedded=true"  style="border: none;width:100%;height:400px;" onload="loadiframe();" id="iframe" name="<?php echo $file_name; ?>" ></iframe>
<?php //unlink(APPPATH.'../uploads/'.$file_name);?>
<?php } ?>
