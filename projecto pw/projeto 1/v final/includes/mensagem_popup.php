<?php
if(isset($_SESSION["mensagem"]))
{
	?>
	<script>
	var test = '<?php echo $_SESSION['mensagem'];?>'; 
	alert(''+test);
	</script>
	<?php
}
unset($_SESSION["mensagem"]);
?>



