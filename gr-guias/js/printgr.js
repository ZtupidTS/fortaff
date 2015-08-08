function printGr(id)
{
    //registo de que imprimiu a guia de novo
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
                window.open("pdf/printgr.php?id="+id, '_blank');
                //window.location = "pdf/printgr.php?id="+id;                
            }else{
                alert(xhr.responseText);
                //alert('tenta de novo');
            }            
        }
    }
    xhr.open("POST","ajax/ajregistogr.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("id="+id+"&why=Imprimiu de novo a guia");
}