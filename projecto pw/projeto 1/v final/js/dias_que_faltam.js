function DiasFaltam()
{
	var dia_actual = new Date();
	// ano vai ficar com o ano da data capturada anteriormente
	var ano = dia_actual.getFullYear();
	//new Date(year, month, day, hours, minutes, seconds, milliseconds)
	var inicio_jogos = new Date(2012,05,27,20,0,0,0);
	// tempo em millisegundos
	var tempo_restante = inicio_jogos - dia_actual.getTime();
	//var tempo_restante = inicio_jogos.getTime() - dia_actual.getTime();
	//converter para segundo, minutos, horas e dias.
	var s_rest = tempo_restante / 1000;
	var m_rest = s_rest / 60;
	var h_rest = m_rest / 60;
	var d_rest = h_rest / 24;
	
	//agora arredondar os valores	
	s_rest = Math.floor(s_rest % 60);
	m_rest = Math.floor(m_rest % 60);
	h_rest = Math.floor(h_rest % 24);
	d_rest = Math.floor(d_rest);
	
	var dias_que_faltam = 'Faltam '+d_rest+' dias '+h_rest+' horas '+m_rest+' minutos '+s_rest+' segundos para poder alterar e/ou eliminar equipas e atletas';
	
	document.getElementById("relogio").innerHTML = dias_que_faltam;
}
setInterval(DiasFaltam, 1000);