<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>O Ponto</title>

	<link rel="stylesheet" href="<?= base_url('includes/bootstrap/css/bootstrap.css') ?>">
	<link rel="stylesheet" href="<?= base_url('includes/bootstrap/css/bootstrap-datetimepicker.css') ?>">
	<link rel="stylesheet" href="<?= base_url('includes/css/lobibox.css') ?>">
	<link rel="stylesheet" href="<?= base_url('includes/css/datatables.min.css') ?>">
	
	<!-- script js -->
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	<script src="<?= base_url('includes/bootstrap/js/jquery.min.js') ?>"></script>
	<script src="<?= base_url('includes/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('includes/bootstrap/js/html5shiv.js') ?>"></script>
    	<script src="<?= base_url('includes/bootstrap/js/respond.js') ?>"></script>
    	<script src="<?= base_url('includes/bootstrap/js/bootstrap-datetimepicker.pt.js') ?>"></script>
    	<script src="<?= base_url('includes/bootstrap/js/bootstrap-datetimepicker.js') ?>"></script>
      	
      	<!-- O js dos popups -->
      	<script src="<?= base_url('includes/js/jquery.noty.packaged.min.js') ?>"></script>
      	<script src="<?= base_url('includes/js/lobibox.min.js') ?>"></script>
      	<script src="<?= base_url('includes/js/datatables.min.js') ?>"></script>
      	
      	<!-- Meus scripts -->
      	<script src="<?= base_url('includes/js/submitform.js') ?>"></script>
</head>
<body>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><img src="<?= base_url('images/eleclerc.jpg');?>" height="30px" width="150px" /></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<!--<li><a href="#">Menu</a></li>
				<li><a href="#">Link</a></li>-->
				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu<span class="caret"></span></a>
				<ul class="dropdown-menu">
				<li><a href="<?= base_url('home') ?>">Problemas Picagens</a></li>
				<!--<li><a href="#">Another action</a></li>
				<li><a href="#">Something else here</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="#">Separated link</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="#">One more separated link</a></li>-->
				</ul>
				</li>
			</ul>
			<!--<form class="navbar-form navbar-left" role="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>-->
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?= base_url('login/logout') ?>">Sair</a></li>
				<!--<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">Separated link</a></li>
				</ul>
				</li>-->
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>


<div class="col-md-10 col-md-offset-1">
	<legend>Corrigir Picagens</legend>
</div>


<?php if (isset($erro)){ ?>
	<div class="alert alert-danger col-md-5 col-md-offset-3" role="alert" style="margin-top: 10px;"><?= $erro; ?></div>
<?php } ?>

<div class="row top10">
	<?php
	if(isset($informacao) && $informacao != "")
	{?>
		<!-- sem resultados -->
		<div class="col-md-10 col-md-offset-1">	
			<div class="col-md-4 col-md-offset-4">
				<?= $informacao;?>	
			</div>
		</div>
		<?php
	}else{
		if(isset($result))
		{
			?>
			<!--Resultados-->
			<div class="col-md-3 col-md-offset-4 table-responsive">
				<table class="table table-hover picagens display" id="picagens">
					<caption>
						<!-- Form para voltar a pagina das picagens -->
						<form hidden id="formback" class="form-inline" role="form" method="post" action="<?= base_url('home/verify_picagens');?>">
							<input type="text" id="datefirst" value="<?= $datefirst;?>" class="form-control" required name="datefirst">	
							<input type="text" id="datesecond" value="<?= $datesecond;?>" class="form-control" required name="datesecond">							
						</form>
						<button type="button" id="btn_back" class="btn btn-default" onclick="submitformback()">Voltar</button>
						<div class="top7">
							<?php 
							$newdate = date_create($datapicagem);
							echo $nomeuser.' Do Dia '.date_format($newdate,'d-m-Y');
							?>
						</div>	
					</caption>
					<thead>
				      		<tr>
				        		<th data-sort="int">Logid</th>
				        		<th>CheckTime</th>
				        		<th>Editar</th>
				        		<th>Eliminar</th>
				      		</tr>
				    	</thead>
				    	<tbody>
					<?php
					$i = 1;
					foreach($result as $row)
					{?>
						<tr class="<?= 'td'.$i;?>">
							<td><?= $row['Logid'];?></td>
							<td id="<?= 'td'.$i;?>">
								<?php
								$newdate = date_create($row['CheckTime']);
								echo date_format($newdate,'H:i:s');
								?>	
							</td>
							<td onclick="editpicagem(<?= $row['Logid'];?>,'<?= 'td'.$i;?>')"><img src="<?= base_url('images/edit.png');?>" height="20px" width="20px" ></td>
							<td onclick="delpicagem(<?= $row['Logid'];?>,'<?= 'td'.$i;?>')"><img src="<?= base_url('images/remove.png');?>" height="20px" width="20px" ></td>
						</tr>
						<?php
						$i++;
					}?>
					</tbody>
				</table>
				<div>
					<button type="button" class="btn btn-default pull-right" onclick="addPicagem()">Adicionar Picagem</button>
				</div>
			</div>
			<?php
		}
	}?>
</div>

<!-- Form modal -->
<div class="modal fade" id="modalChangePicagem" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				
				<h4 class="modal-title">Editar Picagem</h4>
			</div>
			<form id="formmodal" name="formmodal" role="form" method="post">
				<div class="modal-body">
					<div class="form-group">
						<label for="antigapicagem" class="control-label">Antiga Picagem:</label>
						<input type="text" size="30" class="form-control" name="antigapicagem" id="antigapicagem" readonly>
					</div>
					<div class="form-group">
						<label for="novapicagem" class="control-label">Nova Picagem:</label>
						<input type="time" step="1" size="30" class="form-control" name="novapicagem" id="novapicagem">
					</div>
					<!-- aqui a parte do form escondido -->
					<div class="form-group" hidden>
						<input type="text" class="form-control" name="logid" id="logid">
						<input type="text" class="form-control" name="datapicagem" id="datapicagem" value="<?= $datapicagem;?>">
						<input type="text" class="form-control" name="iduser" id="iduser" value="<?= $iduser;?>">
						<input type="text" class="form-control" name="datefirst" id="datefirst" value="<?= $datefirst;?>">
						<input type="text" class="form-control" name="datesecond" id="datesecond" value="<?= $datesecond;?>">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="modalclose" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" >Save changes</button>
				</div>
			</form>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<script>
//var datapicagem = '<?= $datapicagem;?>';
var newtd = '';
function editpicagem(logid,td)
{
	newtd = '#'+td;
	var horaold = $.trim($(newtd).html());
	$('#antigapicagem').val(horaold);
	$('#logid').val(logid);
	$('#novapicagem').val('');	
	$('#modalChangePicagem').modal({
		keyboard: true	
	});	
}
function delpicagem(logid,td)
{
	newtd = '#'+td;
	newtr = '.' +td;
	$('#logid').val(logid);
	
    	Lobibox.confirm({
	    	msg: "Pretende eliminar essa picagem? (não se pode voltar atrás)",
	    	buttonsAlign: 'right',
	    	title: 'Pergunta',
	    	buttons: {
		        yes: {
		            'class': 'lobibox-btn lobibox-btn-yes',
		            text: 'Sim',
		            closeOnClick: true
		        },
		        no: {
		            'class': 'lobibox-btn lobibox-btn-no',
		            text: 'Não',
		            closeOnClick: true
		        }
		},
	    	callback: function ($this, type, ev) {
		        if(type == 'yes')
		        {
				$.ajax({
				        url: '<?= base_url("home/del_picagem");?>',
				        type: 'post',
				        dataType: 'json',
				        data: $('#formmodal').serializeArray(),
				        success: function(data) {
				        		//console.log(data);
				  			if(data.return == 'success')
				  			{
								noty({ 
							    		text: data.message,
							    		type: "success",
							    		layout: "center",
							    		closeWith: ['click', 'hover']
							    	});
							    	//hide this tr
							    	$(newtr).hide();	
							}else{
								noty({ 
							    		text: data.message,
							    		type: "error",
							    		layout: "center",
							    		closeWith: ['click', 'hover']
							    	});
							}
				                },
				        error: function(xhr, textStatus, errorThrown) {
				        		alert("Erro no envio do pedido por ajax: "+xhr.responseText); 
				        	}
			    	});
			}
		}
	});
	return false;
}
$('#formmodal').submit(function() {
	var novapica = $('#novapicagem').val();
	$.ajax({
	        url: '<?= base_url("home/editar_picagem");?>',
	        type: 'post',
	        dataType: 'json',
	        data: $('#formmodal').serializeArray(),
	        success: function(data) {
	        		//console.log(data);
	        		if(data.return == 'success')
	  			{
					noty({ 
				    		text: data.message,
				    		type: "success",
				    		layout: "center",
				    		closeWith: ['click', 'hover']
				    	});
					$(newtd).html(novapica+':00');
	  				$('#modalclose').click();	
				}else{
					noty({ 
				    		text: data.message,
				    		type: "error",
				    		layout: "center",
				    		closeWith: ['click', 'hover']
				    	});
				}
	                },
	        error: function(xhr, textStatus, errorThrown) {
	        		alert("Erro no envio do pedido por ajax: "+xhr.responseText); 
	        	}
    	});
    	return false;
}); 

function submitformback()
{
	$('#formback').submit();
}

function addPicagem()
{
	Lobibox.prompt('addpicagem',{
	    	title: 'Hora da picagem a inserir:',
	    	buttonsAlign: 'right',
	    	draggable: true,
	    	buttons: {
		        ok: {
		            	closeOnClick: true,
            			text: 'Inserir'
		        },
		        cancel: {
		            	closeOnClick: true,
            			text: 'Cancelar'
		        }
		},
		attrs: {
       			placeholder: "__:__:__",
    		},	
	    	callback: function ($this, type, ev) {
		        if(type == 'ok')
		        {
		        	var regex = new RegExp("(([0-1][0-9])|([2][0-3])):([0-5][0-9]):([0-5][0-9])");
		        	var newpicagem = $this.getValue();
		        	if (regex.test(newpicagem) && newpicagem.length < 9) 
		        	{
		        		$('#novapicagem').val(newpicagem);
		        		$.ajax({
					        url: '<?= base_url("home/add_picagem");?>',
					        type: 'post',
					        dataType: 'json',
					        data: $('#formmodal').serializeArray(),
					        success: function(data) {
					        		if(data.return == 'success')
					  			{
									noty({ 
								    		text: data.message,
								    		type: "success",
								    		layout: "center",
								    		closeWith: ['click', 'hover']
								    	});
								    	var rowCount = $('.picagens tr').length;
								    	$('.picagens').last().append('<tr class="td'+rowCount+'"><td>'+data.Logid+'</td><td id="td'+rowCount+'">'+newpicagem+'</td><td onclick="editpicagem('+data.Logid+',&#39;td'+rowCount+'&#39;)"><img src="<?= base_url("images/edit.png");?>" height="20px" width="20px" ></td>' +
								    	'<td onclick="delpicagem('+data.Logid+',&#39;td'+rowCount+'&#39;)"><img src="<?= base_url("images/remove.png");?>" height="20px" width="20px" ></td></tr>');
								    	sortTable();
								}else{
									noty({ 
								    		text: data.message,
								    		type: "error",
								    		layout: "center",
								    		closeWith: ['click', 'hover']
								    	});
								}
					                },
					        error: function(xhr, textStatus, errorThrown) {
					        		alert("Erro no envio do pedido por ajax: "+xhr.responseText); 
					        	}
				    	});	
		        	}else{
					noty({ 
				    		text: 'A hora da picagem tem que ter o seguinte formato: 12:01:00',
				    		type: "error",
				    		layout: "center",
				    		closeWith: ['click', 'hover']
				    	});	
				}
			}
		}
	});
	
}
</script>

<script type="text/javascript">
$(document).ready(function() {
    	$('#picagens').DataTable({
    		"language": {
            		"lengthMenu": "Ver _MENU_ linhas por paginas",
            		"zeroRecords": "Não foi encontrado nada",
            		"info": "Pagina _PAGE_ de _PAGES_",
            		"infoEmpty": "Não há guias inseridas",
            		"infoFiltered": "(Filtro de _MAX_ linhas)",
            		"sSearch": "Procurar:",	
            		"oPaginate": {
				"sFirst":    "Primeira",
				"sLast":     "Ultima",
				"sNext":     "Proxima",
				"sPrevious": "Anterior"
			}
            	},
            	"scrollY": "400px",
        	"scrollCollapse": true,
        	"paging": true,
        	"scrollX": true 
    	});
    } );


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