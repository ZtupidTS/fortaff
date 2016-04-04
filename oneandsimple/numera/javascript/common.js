//Select All
$(document).ready(function(){	
	$('#selectAll').click(function(){
		$('.selectRow').attr("checked","checked");
		$('.selectRow').parent().parent().addClass('selected');
	});
	$('#selectNone').click(function(){
		$('.selectRow').removeAttr("checked");
		$('.selectRow').parent().parent().removeClass('selected');
	});
	$('.selectRow').click(function(){
		if($(this).attr("checked")){
			$(this).parent().parent().addClass('selected');
		}
		else{
			$(this).parent().parent().removeClass('selected');
		}
	});
	
	initCalendar();
	
	/*Add more contact persons*/
	$('#addMore').click(function(){
		//$("#contactperson ul").clone().appendTo("#more");
		
		var countcp  = $("#countcp").val();
		var i = countcp;
		var cpersonli = '<ul class="tab-field" id="cp'+i+'"><li><span><label for="name">Person Name:</label></span><div class="input-divs"><input type="text" id="personname" value="" name="cp['+i+'][personname]"></div></li><li><span><label for="profession">Profession:</label></span><div class="input-divs"><input type="text" id="personprofession" value="" name="cp['+i+'][personprofession]"></div></li><li><span><label for="email">Email:</label></span><div class="input-divs"><input type="text" id="personemail" value="" name="cp['+i+'][personemail]"></div></li><li><span><label for="phone">Phone:</label></span><div class="input-divs"><input type="text" id="personphone" value="" name="cp['+i+'][personphone]"></div></li><li><img src="http://localhost/numera/images/icons/icn.alert.negative.gif" title="click to remove this" class="revmovecp" id="rmvcp" onclick="removecp('+i+')"/><hr></li></ul>';
		//('#addcperson').append($(this).children('div.aacperson').clone());	
		$(cpersonli).appendTo('#addcperson');
		countcp++;
		$("#countcp").val(countcp);
		
	});
	
	/*Add more services*/
	$('#addmoreservices').click(function(){
		//$("#contactperson ul").clone().appendTo("#more");
		
		var countservice  = $("#countservice").val();
		var i = countservice;
		var clientserviceli='<ul class="tab-field" id="service'+i+'"><li><span><label for="serviceName">Service Name:</label></span><div class="input-divs"><input type="text" id="serviceName" value="" name="services['+i+'][serviceName]"></div></li><li><span><label for="serviceDescription">Description:</label></span><div class="input-divs"><textarea id="serviceDescription" rows="10" cols="40" name="services['+i+'][serviceDescription]"></textarea></div></li><li><span><label for="startingDate">Starting Date:</label></span><div class="example-container"><div class="input-divs"><input type="text" id="startingDate2" value="" name="services['+i+'][startingDate]" class="startingDate"></div></div></li><li><span><label for="phone">Ending Date:</label></span><div class="example-container"><div class="input-divs"><input type="text" id="endingDate2" value="" name="services['+i+'][endingDate]" class="endingDate"></div></div></li><li><img src="http://localhost/numera/images/icons/icn.alert.negative.gif" title="click to remove this" class="revmovecp" id="rmvcp" onclick="removeservice('+i+')"/><hr></li></ul>';
		$(clientserviceli).appendTo('#addclientservice');
		countservice++;
		$("#countservice").val(countservice);
		initCalendar();
		
	});
 });

	function initCalendar(){
		$(".startingDate").datetimepicker();
		$(".endingDate").datetimepicker();
	}


	function removecp(id)
	{
		$('#cp'+id).remove();
	}
	
	function removeservice(id)
	{
		$('#service'+id).remove();
	}