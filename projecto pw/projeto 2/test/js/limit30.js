function Limita30(dias)
{
	if(dias < 30)
	{
		
		var css = document.getElementsByName('limit30');
		for(var i=0;i<css.length;i++)
		{
			css[i].style.visibility="hidden";
			css[i].style.display="none";
		}
		var test = true;
		if(dias < 0)
		{
			alert('J� ultrapassou a data do in�cio dos Jogos Olimpicos.\nN�o vai poder efectuar altera��es nas equipas e atletas.\nObrigado pela compreens�o.');
			test = false;
		}
		if(test && dias == 0)
		{
			alert('J� � o ultimo dia antes do in�cio dos Jogos Olimpicos.\nN�o vai poder efectuar altera��es nas equipas e atletas.\nObrigado pela compreens�o.');
			test = false;
		}
		if(test && dias < 30)
		{
			alert('J� s� faltam '+dias+' dia(s) antes do in�cio dos Jogos Olimpicos.\nN�o vai poder efectuar altera��es nas equipas e atletas.\nObrigado pela compreens�o.');
			test = false;
		}
	}
}