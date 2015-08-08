function verDataRep(namebutton)
{
    	//alert(namebutton);
    	var idgr = $('#valorsearch').val();
    	if(idgr.length > 0)
    	{
	  	$.get( "ajax/ajviewrep.php", { campo: $('#valorsearch').val(), buttonname: namebutton } )
		   	.done(function( data ) {
			    /*alert( "Data Loaded: " + data );*/
			    $("#requestajviewgr").html( data );
		});
		$('#importtalao').show();
		$('#importtalao2').show();		
	}else{
		$("#requestajviewgr").html("");
		$('#importtalao').hide();
		$('#importtalao2').hide();
	}
}