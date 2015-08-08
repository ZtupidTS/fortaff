function validateInsertRep()
{
    //nome
    if( document.insertreparador.rep_name.value == "" )
    {
        alert( "Tem de preencher o nome" );
        document.insertreparador.rep_name.focus() ;
        return false;
    }
    //contacto
    if( document.insertreparador.rep_telefone1.value != "" )
    {
        var pattern = /[0-9]{9}/;
        if(!pattern.test(document.insertreparador.rep_telefone1.value)) {
            alert( "Tem de preencher contacto do cliente" );
            document.insertreparador.rep_telefone1.focus() ;
            return false;
        }
    }
    if( document.insertreparador.rep_telefone2.value != "" )
    {
        var pattern = /[0-9]{9}/;
        if(!pattern.test(document.insertreparador.rep_telefone2.value)) {
            alert( "Tem de preencher contacto do cliente" );
            document.insertreparador.rep_telefone2.focus() ;
            return false;
        }
    }
    //email
    if( document.insertreparador.rep_email.value != "" )
    {
        var mail = document.insertreparador.rep_email.value;
        var atpos = mail.indexOf("@");
	var dotpos = mail.lastIndexOf(".");
	if (atpos<1 || dotpos < atpos+2 || dotpos+2 >= mail.length)
  	{
  		alert("Verificar o email introduzido");
  		return false;
  	}
    }
    if( document.insertreparador.rep_email2.value != "" )
    {
        var mail = document.insertreparador.rep_email2.value;
        var atpos = mail.indexOf("@");
	var dotpos = mail.lastIndexOf(".");
	if (atpos<1 || dotpos < atpos+2 || dotpos+2 >= mail.length)
  	{
  		alert("Verificar o email introduzido");
  		return false;
  	}
    }
    
    
    //faço o ajax da submissão do form
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
            var xhr=new XMLHttpRequest();
    }else{// code for IE6, IE5
            var xhr=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr.onreadystatechange=function()
    {
        if (xhr.readyState==4 && xhr.status==200)
        {
            if(trimStr(xhr.responseText) == 'ok')
            {
                //se recebo o ok da submissão imprimo o pdf.
                //alert('Reparador inserido com sucesso');
                alert('Reparador criado com sucesso');
                window.location = "index.php";
            }else{
                //alert(xhr.responseText);
                alert('tenta de novo');
            }            
        }
    }
    //obter todos os valores dos campos.
    var name = document.insertreparador.rep_name.value;
    
    var postajax = "rep_name="+name;
    
    if(document.insertreparador.rep_morada.value != "")
    {
        postajax = postajax+"&rep_morada="+document.insertreparador.rep_morada.value;
    }
    if(document.insertreparador.rep_email.value != "")
    {
        postajax = postajax+"&rep_email="+document.insertreparador.rep_email.value;
    }
    if(document.insertreparador.rep_email2.value != "")
    {
        postajax = postajax+"&rep_email2="+document.insertreparador.rep_email2.value;
    }
    if(document.insertreparador.rep_telefone1.value != "")
    {
        postajax = postajax+"&rep_telefone1="+document.insertreparador.rep_telefone1.value;
    }
    if(document.insertreparador.rep_nome1.value != "")
    {
        postajax = postajax+"&rep_nome1="+document.insertreparador.rep_nome1.value;
    }
    if(document.insertreparador.rep_telefone2.value != "")
    {
        postajax = postajax+"&rep_telefone2="+document.insertreparador.rep_telefone2.value;
    }
    if(document.insertreparador.rep_nome2.value != "")
    {
        postajax = postajax+"&rep_nome2="+document.insertreparador.rep_nome2.value;
    }
    
    xhr.open("POST","ajax/ajinsertrep.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send(postajax);
}

