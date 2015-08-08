function verDataGr(namebutton)
{
    	//alert(namebutton);
    	var idgr = $('#valorsearch').val();
    	if(idgr.length > 0)
    	{
	  	$.get( "ajax/ajviewgr.php", { campo: $('#valorsearch').val(), buttonname: namebutton } )
		   	.done(function( data ) {
			    /*alert( "Data Loaded: " + data );*/
			    if(data.length > 40)
			    {
			    	$("#requestajviewgr").html( data );
			    	//alert(data.length);
			    	$('#suppliertype').show();	
			    }else{
			    	$('#suppliertype').hide();
			    }
		});
		$('#importtalao').show();
		$('#importtalao2').show();
	}else{
		$("#requestajviewgr").html("");
		$('#importtalao').hide();
		$('#importtalao2').hide();
		$('#suppliertype').hide();
	}
}