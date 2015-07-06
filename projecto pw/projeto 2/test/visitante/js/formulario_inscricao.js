// Para desativar os span com a class "tooltips"
function deactivateTooltips() 
{
    var spans = $$('span'),
    spansLength = spans.length;
	for (var i = 0 ; i < spansLength ; i++) 
	{
        if (spans[i].className == 'tooltip') 
		{
            spans[i].style.display = 'none';
        }
    }
}
// recuperar os span da class tooltip referente ao input que estamos a escrever
function getTooltip(element)
{
    while (element = element.nextSibling) 
	{
        if (element.className === 'tooltip') 
		{
            return element;
        }
    }    
    return false;
}
// Verificar os inputs
var check = {}; // todas as funções a seguir ficam nesse elemento

check['apelido'] = function(id) 
{
    var name = $(id),
        tooltipStyle = getTooltip(name).style;

    if (name.value.length >= 2 && name.value.length <30) 
	{
        name.className = 'correct';
        tooltipStyle.display = 'none';
        return true;
    }else{
        name.className = 'incorrect';
        tooltipStyle.display = 'inline-block';
        return false;
    }
};

check['nome'] = check['apelido']; // para o nome e apelido é a mesma coisa por isso digo que é igual

check['morada'] = function(id) 
{
    var name = $(id),
        tooltipStyle = getTooltip(name).style;

    if (name.value.length >= 0 && name.value.length <240) 
	{
        name.className = 'correct';
        tooltipStyle.display = 'none';
        return true;
    }else{
        name.className = 'incorrect';
        tooltipStyle.display = 'inline-block';
        return false;
    }
};

check['nif'] = function(id) 
{
    var nif = $(id),
        tooltipStyle = getTooltip(nif).style,
        nifValue = parseInt(nif.value);
    
    if (!isNaN(nifValue) && nif.value.length == 9) 
	{
        nif.className = 'correct';
        tooltipStyle.display = 'none';
        return true;
    }else{
        nif.className = 'incorrect';
        tooltipStyle.display = 'inline-block';
        return false;
    }
};

check['telemovel'] = check['nif'];

check['email1'] = function() 
{
    var email = $('email1'),
        tooltipStyle = getTooltip(email).style;
    
    if (email.value.length > 1) 
	{
        email.className = 'correct';
        tooltipStyle.display = 'none';
        return true;
    }else{
        email.className = 'incorrect';
        tooltipStyle.display = 'inline-block';
        return false;
    }
};

check['email2'] = function() 
{
    var email = $('email2'),
        tooltipStyle = getTooltip(email).style;
    
    if (email.value.length > 1) 
	{
        email.className = 'correct';
        tooltipStyle.display = 'none';
        return true;
    }else{
        email.className = 'incorrect';
        tooltipStyle.display = 'inline-block';
        return false;
    }
};

check['login'] = function() 
{
    var login = $('login'),
        tooltipStyle = getTooltip(login).style;
    
    if (login.value.length >= 4 && login.value.length <31) 
	{
        login.className = 'correct';
        tooltipStyle.display = 'none';
        return true;
    }else{
        login.className = 'incorrect';
        tooltipStyle.display = 'inline-block';
        return false;
    }
};

check['psw'] = function() 
{
    var psw = $('psw'),
        tooltipStyle = getTooltip(psw).style;
    
    if (psw.value.length >= 4 && psw.value.length <31) 
	{
        psw.className = 'correct';
        tooltipStyle.display = 'none';
        return true;
    }else{
        psw.className = 'incorrect';
        tooltipStyle.display = 'inline-block';
        return false;
    }
};

check['psw2'] = function() 
{
    var psw = $('psw'),
        psw2 = $('psw2'),
        tooltipStyle = getTooltip(psw2).style;
    
    if (psw.value == psw2.value && psw2.value != '') 
	{
        psw2.className = 'correct';
        tooltipStyle.display = 'none';
        return true;
    }else{
        psw2.className = 'incorrect';
        tooltipStyle.display = 'inline-block';
        return false;
    }
};
// Os events
(function() 
{ 
    var myForm = $('form_table'),
        inputs = $$('input'),
        inputsLength = inputs.length;

    for (var i = 0 ; i < inputsLength ; i++) 
	{
        if (inputs[i].type == 'text' || inputs[i].type == 'password') 
		{
            inputs[i].onkeyup = function() 
			{
                check[this.id](this.id); // "this" representa o input que esta a ser modificado
            };
        }
    }
    myForm.onsubmit = function() 
	{
        var result = true;

        for (var i in check) 
		{
            result = check[i](i) && result;
			//alert(result);
        }
        if (result) 
		{
            alert('Formulario mal preenchido');
        }else{
			alert('Formulario mal preenchido');
		}
        //return false;
    };
    myForm.onreset = function() 
	{
        for (var i = 0 ; i < inputsLength ; i++) 
		{
            if (inputs[i].type == 'text' || inputs[i].type == 'password') 
			{
                inputs[i].className = '';
            }
        }
        deactivateTooltips();
    };
})();
// ao carregar a pagina e esse include desativa logo todas as dicas
deactivateTooltips();