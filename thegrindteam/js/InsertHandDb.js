function InsertHandDb()
{
    var hh_title = $('title_hand').value;
    var classification = $('classification').value;
    var hh_iduser = $('idusers').value;
    var hh_hand_temp = $('hand').value;
    var hh_hand_temp1 = hh_hand_temp.replace(/\&nbsp;/g,' ');
    var hh_hand = hh_hand_temp1.replace('<font color=#FFFFFF>',' ');
//                    var hh_hand_temp3 = hh_hand_temp2.replace(\"http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif"/g,'../images/diamond.gif');
//                    var hh_hand_temp4 = hh_hand_temp3.replace(\"http://www.flopturnriver.com/pokerforum/images/smilies/club.gif"/g,'../images/club.gif');
//                    var hh_hand_temp5 = hh_hand_temp4.replace(\"http://www.flopturnriver.com/pokerforum/images/smilies/heart.gif"/g,'../images/heart.gif');
//                    var hh_hand = hh_hand_temp5.replace(\"http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"/g,'../images/spade.gif');

    var hh_thinkingprocess_1 = $('thinkingprocess').value;
    var hh_thinkingprocess_2 = hh_thinkingprocess_1.replace(/\n\r?/g, '<br />');
    var hh_thinkingprocess = hh_thinkingprocess_2.replace(/\+/g, '%2B');
    var hh_image = $('image').value;
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
                if(xhr.responseText.trim().slice(0,2) == 'ok')
                {
                    $('title_hand').value = "";
                    $('hand').value = "";
                    $('thinkingprocess').value = "";
                    $('image').value = "";
                    alert('Hand accept');
                }else{
                    alert(xhr.responseText);
                }
                //$("txtchange").innerHTML=xhr.responseText;                                
            }
    }
    xhr.open("POST","ajax/aj_verif_inserthand.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('title='+hh_title+'&iduser='+hh_iduser+'&hand='+hh_hand+'&thinkingprocess='+hh_thinkingprocess+'&image='+hh_image+'&class='+classification);
    //xhr.open("GET",'ajax/verif_inserthand.php?title='+hh_title+'&iduser='+hh_iduser+'&hand='+hh_hand+'&thinkingprocess='+hh_thinkingprocess+'&image='+hh_image,true);
    //xhr.send();

}

