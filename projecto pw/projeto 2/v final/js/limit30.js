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
			alert('Já ultrapassou a data do início dos Jogos Olimpicos.\nNão vai poder efectuar alterações nas equipas e atletas.\nObrigado pela compreensão.');
			test = false;
		}
		if(test && dias == 0)
		{
			alert('Já é o ultimo dia antes do início dos Jogos Olimpicos.\nNão vai poder efectuar alterações nas equipas e atletas.\nObrigado pela compreensão.');
			test = false;
		}
		if(test && dias < 30)
		{
			alert('Já só faltam '+dias+' dia(s) antes do início dos Jogos Olimpicos.\nNão vai poder efectuar alterações nas equipas e atletas.\nObrigado pela compreensão.');
			test = false;
		}
	}
}