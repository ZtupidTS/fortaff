var novopreco = 1;
function calcValor()
{
	var qtd = $("qtd").value;
	var oldpreco = $("old_preco").value;
	var total = (qtd * oldpreco).toFixed(2);
	novopreco = total;
	$("novo_preco").innerHTML = ''+total+' €  Para';	
	$("amount").value = total;
	$("item_number").value = qtd;
	calcMoeda();
}
function calcMoeda()
{
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
			var cambio = xhr.responseText * novopreco;
			$("cambio").innerHTML= cambio.toFixed(2);
		}
	}
	var moeda = $("moeda").value;
	xhr.open("GET","ajax/euro_conv.php?moeda="+moeda,true);
	xhr.send();
}