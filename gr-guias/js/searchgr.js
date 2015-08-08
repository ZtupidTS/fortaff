function searchGr()
{
    var e = document.getElementById('cbsearchgr');
    var strSearch = e.options[e.selectedIndex].value;
    if(strSearch == '')
    {
        alert('Tem de seleccionar uma escolha');
    }else{
        var valor = document.getElementById("valorsearch").value;
        if(valor == "")
        {
            alert( "Tem de preencher o campo da procura" );
            document.getElementById("valorsearch").focus() ;            
        }else{
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
                    //aqui preencho o meu div com o conteúdo do pedido ajax
                    document.getElementById("requestajviewgr").innerHTML=xhr.responseText;                    
                }
            }
            xhr.open("POST","ajax/ajsearchgr.php",true);
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('campo='+strSearch+'&valor='+valor);
        }                
    }
}
