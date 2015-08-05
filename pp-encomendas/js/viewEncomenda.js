function verEncomenda(paginaclick)
{
    	//alert(paginaclick);
    	var cont = true;
    	var idenc = $('#valorsearch').val();
    	
    	if(idenc != '')
        {
            	var pattern = /[0-9]/;
            	if(!pattern.test(idenc)) {
                	alert( "O numero da guia esta mal preenchido" );
                	document.getElementById('valorsearch').focus();
                	cont = false;
                	return false;
            	}
        }else{
		alert('Não preencheu o numero da encomenda');
		cont = false;
	}
    	
    	if(cont)
    	{
	  	$.get( "ajax/ajviewenc.php", { encomenda: idenc, page: paginaclick } )
		   	.done(function( data ) {
			    /*alert( "Data Loaded: " + data );*/
			    if(data.length > 40)
			    {
			    	$("#requestajviewenc").html( data );
			    	//alert(data.length);
			    	$('#suppliertype').show();	
			    }else{
			    	$('#suppliertype').hide();
			    }
		});
		//$('#importtalao').show();
		//$('#importtalao2').show();
	}else{
		$("#requestajviewenc").html("");
		//$('#importtalao').hide();
		//$('#importtalao2').hide();
		//$('#suppliertype').hide();
	}
}