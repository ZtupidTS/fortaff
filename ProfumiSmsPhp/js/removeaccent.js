function removerAcentos( newStringComAcento ) 
    {
	  var string = newStringComAcento;
	  var mapaAcentosHex 	= {
		a : /[\xE0-\xE6]/g,
		A : /[\xC0-\xC6]/g,
		e : /[\xE8-\xEB]/g,
		E : /[\xC8-\xCB]/g,
		i : /[\xEC-\xEF]/g,
		I : /[\xCC-\xCF]/g,
		o : /[\xF2-\xF6]/g,
		O : /[\xD2-\xD6]/g,
		u : /[\xF9-\xFC]/g,
		U : /[\xD9-\xDC]/g,
		c : /\xE7/g,
		C : /\xC7/g,
		n : /\xF1/g,
		N : /\xD1/g,
	       '' : /[\x60\x5E\x7E\xAB\xBB\xB4\xAA\xBA]/g
	       /*'' : /\x5E/g,//^
	       '' : /\x7E/g,//~
	       '' : /\xAB/g,//«
	       '' : /\xBB/g,//»
	       '' : /\xB4/g,//´
	       '' : /\xAA/g,//ª
	       '' : /\xBA/g,//º
	       '' : /\x2B9/g,//´
	       '' : /\x2BA/g//´*/
	  }
	 
		for ( var letra in mapaAcentosHex ) {
			var expressaoRegular = mapaAcentosHex[letra];
			string = string.replace( expressaoRegular, letra );
		}
	 
		return string;
    }