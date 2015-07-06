function Limita30SemPopup(dias)
{
	if(dias < 30)
	{
		
		var css = document.getElementsByName('limit30');
		for(var i=0;i<css.length;i++)
		{
			css[i].style.visibility="hidden";
			css[i].style.display="none";
		}
	}
}