function validateUpdate()
{
    //nome
    if( document.insertguia.cl_name.value == "" )
    {
        alert( "Tem de preencher o nome do cliente" );
        document.insertguia.cl_name.focus() ;
        return false;
    }
    //morada
    if( document.insertguia.cl_morada.value == "" )
    {
        alert( "Tem de preencher a morada do cliente" );
        document.insertguia.cl_morada.focus() ;
        return false;
    }
    //localidade
    if( document.insertguia.cl_localidade.value == "" )
    {
        alert( "Tem de preencher a localidade do cliente" );
        document.insertguia.cl_localidade.focus() ;
        return false;
    }
    //codigo postal
    if( document.insertguia.cl_codpostal.value == "" || document.insertguia.cl_codpostal.value == "0000-000")
    {
        alert( "Tem de preencher o codigo postal do cliente" );
        document.insertguia.cl_codpostal.focus() ;
        return false;
    }
    if( document.insertguia.cl_codpostal.value != "" )
    {
        var pattern = /[0-9]{4}\-[0-9]{3}/;
        if(!pattern.test(document.insertguia.cl_codpostal.value)) {
            alert("O código Postal é inválido.");
            document.insertguia.cl_codpostal.focus() ;
            return false;
        }
    }
    //contacto
    if( document.insertguia.cl_contacto.value == "")
    {
        alert( "Tem de preencher contacto do cliente" );
        document.insertguia.cl_contacto.focus() ;
        return false;
    }
    if( document.insertguia.cl_contacto.value != "" )
    {
        var pattern = /[0-9]{9}/;
        if(!pattern.test(document.insertguia.cl_contacto.value)) {
            alert( "Tem de preencher contacto do cliente" );
            document.insertguia.cl_contacto.focus() ;
            return false;
        }
    }
    //marca artigo
    if( document.insertguia.art_marca.value == "" )
    {
        alert( "Tem de preencher a marca" );
        document.insertguia.art_marca.focus() ;
        return false;
    }
    //tipo artigo
    if( document.insertguia.art_tipo.value == "" || document.insertguia.art_tipo.value == "maquina...")
    {
        alert( "Tem de preencher o tipo" );
        document.insertguia.art_tipo.focus() ;
        return false;
    }    
    //modelo artigo
    if( document.insertguia.art_modelo.value == "" )
    {
        alert( "Tem de preencher o modelo" );
        document.insertguia.art_modelo.focus() ;
        return false;
    }
    //numero de serie artigo
    if( document.insertguia.art_numserie.value == "" )
    {
        alert( "Tem de preencher o numero de serie, caso não tem meter 'N/A'" );
        document.insertguia.art_numserie.focus() ;
        return false;
    }
    //data de garantia
    if(!document.getElementById("garantia").disabled)
    {
        if( document.insertguia.garantia.value == "" || document.insertguia.garantia.value == "00-00-0000")
        {
            alert( "Tem de preencher a data como indicado" );
            document.insertguia.garantia.focus() ;
            return false;
        }
        if( document.insertguia.garantia.value != "" )
        {
            var pattern = /[0-9]{2}\-[0-9]{2}\-[0-9]{4}/;
            if(!pattern.test(document.insertguia.garantia.value)) {
                alert( "Tem de preencher a data como indicado" );
                document.insertguia.garantia.focus() ;
                return false;
            }
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
                window.location = "pdf/printgr.php";
                //alert('ok');
                //window.location = "index.php";
            }else{
                //alert(xhr.responseText);
                alert('tenta de novo');
            }            
        }
    }
    //obter todos os valores dos campos.
    var name = document.insertguia.cl_name.value;
    var morada = document.insertguia.cl_morada.value;
    var localidade = document.insertguia.cl_localidade.value;
    var codpostal = document.insertguia.cl_codpostal.value;
    var contacto = document.insertguia.cl_contacto.value;
    var marca = document.insertguia.art_marca.value;
    var tipo = document.insertguia.art_tipo.value;
    var modelo = document.insertguia.art_modelo.value;
    var numserie = document.insertguia.art_numserie.value;
    
    var postajax = "cl_name="+name+"&cl_localidade="+localidade+"&cl_morada="+morada+"&cl_codpostal="+codpostal+"&cl_telefone="+contacto+"&art_type="+tipo+"&art_marca="+marca+"&art_modelo="+modelo+"&art_numserie="+numserie;
    
    if(document.insertguia.art_acessorio.value != "")
    {
        postajax = postajax+"&art_acessor="+document.insertguia.art_acessorio.value;
    }
    if(document.insertguia.art_estetic.value != "")
    {
        postajax = postajax+"&art_estetic="+document.insertguia.art_estetic.value;
    }
    if(document.insertguia.art_numtalao.value != "" || document.insertguia.art_numtalao.value != "00/00/00 0 000A 00X00")
    {
        postajax = postajax+"&art_numtalao="+document.insertguia.art_numtalao.value;
    }
    if(document.insertguia.art_valor.value != "")
    {
        postajax = postajax+"&art_valor="+document.insertguia.art_valor.value;
    }
    if(!document.getElementById("garantia").disabled)
    {
        postajax = postajax+"&art_dategar="+document.insertguia.garantia.value+"&art_garantie="+1;        
    }else{
        postajax = postajax+"&art_garantie="+0;        
    }
    if(document.getElementById('art_orcamento').checked == true)
    {
        postajax = postajax+"&art_orcamento="+1;
    }else{
        postajax = postajax+"&art_orcamento="+0;
    }
    if(document.insertguia.art_ean.value != "")
    {
        postajax = postajax+"&art_ean="+document.insertguia.art_ean.value;
    }
    
    xhr.open("POST","ajax/ajinsertgr.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send(postajax);
}

