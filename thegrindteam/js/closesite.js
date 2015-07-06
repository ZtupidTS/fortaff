window.onbeforeunload = closeIt;
//window.onunload = closeIt;

function closeIt()
{
    
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
            var xhr_lasvisit =new XMLHttpRequest();
    }else{// code for IE6, IE5
            var xhr_lasvisit =new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr_lasvisit.onreadystatechange=function()
    {
        if (xhr_lasvisit.readyState==4 && xhr_lasvisit.status==200)
        {
            xhr_lasvisit = null;
        }
        
    }
    xhr_lasvisit.open("POST","ajax/aj_lastvisit.php",true);
    xhr_lasvisit.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr_lasvisit.send('text=11');  
    windows.confirm = true;
    return false;    
}

