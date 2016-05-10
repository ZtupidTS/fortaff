function submitform(url, values)
{
	var inputform = "";
	for (var property in values) {
		if (values.hasOwnProperty(property)) {
	        	//alert('ddd');
			var value = values[property];
			if (value instanceof Array) {
				for (var i = 0, l = value.length; i < l; i++) {
				    	/*form.appendChild(document.createElement("input", {type: "text",
				                                             name: property,
				                                             value: value[i]}));*/
				        inputform = inputform + '<input type="text" name="'+property+'" value="'+value[i]+'">';                                     
				}
			}
			else {
				/*form.appendChild(document.createElement("input", {type: "text",
				                                         name: property,
				                                         value: value}));*/
				inputform = inputform + '<input type="text" name="'+property+'" value="'+value+'">';                                         
			}
	        }
	}
	//console.log('<form method="post" action="'+url+'">' + inputform + '</form>');
	$('<form hidden method="post" action="'+url+'">' + inputform + '</form>').appendTo('body').submit();
}

function createform(url,values)
{
	var inputform = "";
	for (var property in values) {
		if (values.hasOwnProperty(property)) {
	        	//alert('ddd');
			var value = values[property];
			if (value instanceof Array) {
				for (var i = 0, l = value.length; i < l; i++) {
				    	/*form.appendChild(document.createElement("input", {type: "text",
				                                             name: property,
				                                             value: value[i]}));*/
				        inputform = inputform + '<input type="text" name="'+property+'" value="'+value[i]+'">';                                     
				}
			}
			else {
				/*form.appendChild(document.createElement("input", {type: "text",
				                                         name: property,
				                                         value: value}));*/
				inputform = inputform + '<input type="text" name="'+property+'" value="'+value+'">';                                         
			}
	        }
	}
	//console.log('<form method="post" action="'+url+'">' + inputform + '</form>');
	return $('<form hidden method="post" action="'+url+'">' + inputform + '</form>').appendTo('body');	
	
	/*$('<form hidden method="post" action="'+url+'">' + inputform + '</form>').appendTo('body').submit();*/
}
