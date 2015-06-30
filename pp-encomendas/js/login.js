function Login()
{
    var e = document.getElementById('cblogin');
    var strUser = e.options[e.selectedIndex].value;
    if(strUser == '')
    {
        alert('Tem de seleccionar o seu nome');
    }else{
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
        
        var pass = document.getElementById('password').value;
        
        
        xhr.open("POST","ajax/ajlogin.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send('iduser='+strUser+'&password='+pass);
        //xhr.open("GET",'ajax/verif_inserthand.php?title='+hh_title+'&iduser='+hh_iduser+'&hand='+hh_hand+'&thinkingprocess='+hh_thinkingprocess+'&image='+hh_image,true);
        //xhr.send();
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
                        //alert(xhr.responseText);
                        alert('tenta de novo');
                    }
                    //$("txtchange").innerHTML=xhr.responseText;                                
                }
        }
        xhr.open("POST","ajax/ajlogout.php",true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        //xhr.open("GET",'ajax/verif_inserthand.php?title='+hh_title+'&iduser='+hh_iduser+'&hand='+hh_hand+'&thinkingprocess='+hh_thinkingprocess+'&image='+hh_image,true);
        xhr.send();    
}



