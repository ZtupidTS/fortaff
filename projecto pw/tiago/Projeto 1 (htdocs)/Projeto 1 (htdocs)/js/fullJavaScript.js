function str_left(str, n){
	if (n <= 0)
	    return "";
	else if (n > String(str).length)
	    return str;
	else
	    return String(str).substring(0,n);
}

function str_right(str, n){
    if (n <= 0)
       return "";
    else if (n > String(str).length)
       return str;
    else {
       var iLen = String(str).length;
       return String(str).substring(iLen, iLen - n);
    }
}

function selectSelectedValue(selectObj, selectValue)
{
	for (var i = 0; i < selectObj.length; i++)
	{
		if(selectObj.options[i].value == selectValue) {
			selectObj.selectedIndex = i;
			return;
		}
	}
}

function getCheckedValue(radioObj) {

	if (!radioObj) {
		return "";
	}
	
	var radioLength = radioObj.length;
	
	if (radioLength == undefined) {
		if(radioObj.checked) {
			return radioObj.value;
		}
	} else {
		return "";
	}
	
	for (var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	
	return "";
	
}

function setCheckedValue(radioObj, newValue) {

	if(!radioObj) {
		return;
	}
	
	var radioLength = radioObj.length;
	
	if(radioLength == undefined) {
		radioObj.checked = (radioObj.value == newValue.toString());
		return;
	}
	
	for (var i = 0; i < radioLength; i++) {
		radioObj[i].checked = false;
		if(radioObj[i].value == newValue.toString()) {
			radioObj[i].checked = true;
		}
	}
}

function inputPassword(idObj, password)
{
	obj = document.getElementById(idObj);
	obj.type = obj.type == 'text' ? 'password' : 'text';
}

function blinkValidator(id, timer, count)
{
	obj = document.getElementById(id);
	
	if (count == 0) {
		return true;
	}
	
	if (obj.style.visibility == 'hidden') {
		obj.style.visibility = 'visible';
		inc = 1;
	} else {
		obj.style.visibility = 'hidden';
		inc = 0;
	}
	
	setTimeout("blinkValidator('" + id + "' , " + timer + ", " + (count - inc) + ")", timer);
	
}

function hideValidator(id)
{
	obj = document.getElementById(id);
	obj.style.visibility = 'hidden';
}

function setTitleValidator(id, title)
{
	obj = document.getElementById(id);
	obj.title = title;
}

function stringIsDate(str)
{
	if (!str) {
		return false;
	} else {
		return str.replace(/\d{4}-(0[1-9]|1[0-2])-([0-2]\d|3[01])/, "") == "";
	}
}

function stringIsTime(str)
{
	if (!str) {
		return false;
	} else {
		return str.replace(/([0-1]\d|2[0-3]):[0-5]\d:[0-5]\d/, "") == "";
	}
}

function stringIsDateTime(str)
{
	if (!str) {
		return false;
	} else {
		return str.replace(/\d{4}-(0[1-9]|1[0-2])-([0-2]\d|3[01]) ([0-1]\d|2[0-3]):[0-5]\d:[0-5]\d/, "") == "";
	}
}

function stringIsInteger(str)
{
	if (!str) {
		return false;
	} else {
		return str.replace(/(\+|-)?\d+/, "") == "";
	}
}

function stringIsFloat(str)
{
	if (!str) {
		return false;
	} else {
		return str.replace(/(\+|-)?\d+(\.\d+)?/, "") == "";
	}
}

// ######## AJAX ########

function createXMLHttpRequest()
{
	if (window.XMLHttpRequest) {
		// code for ie7+, firefox, chrome, opera, safari
		return new XMLHttpRequest();
	} else {
		// code for ie6, ie5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
}

function loadGetXMLHttpRequest(url, cfunc)
{
	var xmlhttp = createXMLHttpRequest();

	xmlhttp.onreadystatechange = function() { cfunc(xmlhttp); };
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function loadPostXMLHttpRequest(url, str, cfunc)
{
	var xmlhttp = createXMLHttpRequest();

	xmlhttp.onreadystatechange = function() { cfunc(xmlhttp); };
	xmlhttp.open("POST", url, true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(str);
}

function isReadyXMLHttpRequest(xmlhttp)
{
	return (xmlhttp.readyState == 4 && xmlhttp.status == 200);
}

// ######## TABLE PAGING ########

function Pager(tableName, itemsPerPage) {

    this.tableName = tableName;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;
	this.positionId = '';
	this.funcGroup = null;
	
    this.showRecords = function(from, to) {
        var rows = $(tableName).rows;
		var firstVisible = false;
        for (var i = 1; i < rows.length; i++) {
            if (i < from || i > to) {
                rows[i].style.display = 'none';
            } else {
				if (!firstVisible && this.funcGroup) {
					var j = i;
					while (j >= 0 && !this.funcGroup(rows[j])) {j--;};
					if (j > 0) {
						rows[j].style.display = '';
					}
				}
				firstVisible = true;
                rows[i].style.display = '';
			}
        }
    }
    
    this.showPage = function(pageNumber) {
    	if (!this.inited) {
    		alert("not inited");
    		return;
    	}

        var oldPageAnchor = $(this.positionId + '-pg-' + this.currentPage);
        oldPageAnchor.className = 'pg-normal';
		
        this.currentPage = pageNumber;
        var newPageAnchor = $(this.positionId + '-pg-' + this.currentPage);
        newPageAnchor.className = 'pg-selected';

        var from = (pageNumber - 1) * itemsPerPage + 1;
        var to = from + itemsPerPage - 1;
        this.showRecords(from, to);
    }   
    
    this.prev = function() {
        if (this.currentPage > 1)
            this.showPage(this.currentPage - 1);
    }
    
    this.next = function() {
        if (this.currentPage < this.pages) {
            this.showPage(this.currentPage + 1);
        }
    }                        
    
    this.init = function() {
        var rows = $(tableName).rows;
        var records = (rows.length - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
    }

    this.showPageNav = function(pagerName, positionId) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}
    	var element = $(positionId);
		this.positionId = positionId;
    	var pagerHtml = '';
		
    	pagerHtml += this.createPageNav('prev', pagerName);
		pagerHtml += ' | ' + this.createPageNav(1, pagerName);
        for (var page = 2; page <= this.pages; page++) {
            pagerHtml += ' | ' + this.createPageNav(page, pagerName);
		}
        pagerHtml += ' | ' + this.createPageNav('next', pagerName);
        
        element.innerHTML = pagerHtml;
    }
	
	this.createPageNav = function(pageIndex, pagerName) {
		switch (pageIndex) {
			case 'prev':
				return '<span id="' + this.positionId + '-prev" onclick="' + pagerName + '.prev();" class="pg-normal"> &#171 Prev </span>';
				break;
			case 'next':
				return '<span id="' + this.positionId + '-next" onclick="' + pagerName + '.next();" class="pg-normal"> Next &#187;</span>';
				break;
			default:
				return '<span id="' + this.positionId + '-pg-' + pageIndex + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + pageIndex + ');">' + pageIndex + '</span>';
		}
	}
}