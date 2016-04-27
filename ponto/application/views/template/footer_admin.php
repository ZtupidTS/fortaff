<script type="text/javascript">
var tabledatatable = null;
function startDatatable()
{
	tabledatatable = $('#picagens').DataTable({
    		"paging": false,
    		"info": false,
    		"bFilter": false,
    		"order": [[ 1, "asc" ]],
    		"columnDefs": [ {
			"targets": 2,
			"orderable": false
			},{
			"targets": 3,
			"orderable": false
			} ]
    	});
	
}
function startDatatableRp()
{
	tabledatatable = $('#picagens').DataTable({
    		"paging": false,
    		"info": false,
    		"bFilter": false
    		//"order": [[ 1, "asc" ]],
    		/*"columnDefs": [ {
			"targets": 2,
			"orderable": false
			},{
			"targets": 3,
			"orderable": false
			} ]*/
    	});
	
}

$(document).ready(function() {
	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
</script>
</body>
</html>