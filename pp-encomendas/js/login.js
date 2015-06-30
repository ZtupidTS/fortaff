function Login()
{
    var strUser = $('#cblogin').find('option:selected').text();
    if(strUser == '')
    {
        alert('Tem de seleccionar o seu nome');
    }else{
        $.get( "ajax/ajlogin.php", { 
        	iduser: $('#cblogin').find('option:selected').val(),
        	login: strUser,
        	password: $('#password').val() }, 'text' )
		   	.done(function( data ) {
		   	    var newdata = data.trim();
			    /*alert( "Data Loaded: " + data );*/
			    if(newdata == "ok")
			    {
			    	//$("#requestajviewgr").html( data );
			    	//alert(newdata);
			    	window.location = "index.php";
			    	//$('#suppliertype').show();	
			    }else{
			    	//$('#suppliertype').hide();
			    	alert(newdata);
			    }
		});
        
    }
}
function Logout()
{
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
                var xhr=new XMLHttpRequest();
        }else{// code for IE6, IE5
                var xhr=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.onreadystatechange=function()
        {
    //                            alert("rtyuu"+xhr.readyState);
    //                            alert(''+xhr.status);
                if (xhr.readyState==4 && xhr.status==200)
                {
                    if(trimStr(xhr.responseText) == 'ok')
                    {
                        //alert(xhr.responseText);
                        window.location = "index.php";
                    }else{
                        alert(xhr.responseText);
                        //alert('tenta de novo');
                    }
                    //$("txtchange").innerHTML=xhr.responseText;                                
                }
        }
        xhr.open("POST","ajax/ajlogout.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        //xhr.open("GET",'ajax/verif_inserthand.php?title='+hh_title+'&iduser='+hh_iduser+'&hand='+hh_hand+'&thinkingprocess='+hh_thinkingprocess+'&image='+hh_image,true);
        xhr.send();    
}
