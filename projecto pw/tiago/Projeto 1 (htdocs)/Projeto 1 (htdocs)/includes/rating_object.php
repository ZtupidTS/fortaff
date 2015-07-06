<?php
	$input_star_id = "input_star_id";
	$input_star_name = "input_star_name";
	$input_star_value = -1;
	$input_star_readonly = false;
	$div_star_class = "star_style";
	$div_star_style = "";
	
	if (isset($_SESSION['rating_object'])) {
		$rating_object_status = $_SESSION['rating_object'];
		if (isset($rating_object_status['id'])) {
			$input_star_id = $rating_object_status['id'];
		}
		if (isset($rating_object_status['name'])) {
			$input_star_name = $rating_object_status['name'];
		}
		if (isset($rating_object_status['value'])) {
			$input_star_value = intval($rating_object_status['value']);
		}
		if (isset($rating_object_status['readonly']) && $rating_object_status['readonly'] == 'true') {
			$input_star_readonly = true;
		}
		if (isset($rating_object_status['class'])) {
			$div_star_class = $rating_object_status['class'];
		}
		if (isset($rating_object_status['style'])) {
			$div_star_style = $rating_object_status['style'];
		}
	}
?>
<div class="<?= $div_star_class ?>" style="<?= $div_star_style ?>" >
	<img id="1star1_<?= $input_star_id ?>" src="/pw606/img/star_<?= $input_star_value < 1 ? 'grey' : 'yellow' ?>.png" />
	<img id="2star2_<?= $input_star_id ?>" src="/pw606/img/star_<?= $input_star_value < 2 ? 'grey' : 'yellow' ?>.png" />
	<img id="3star3_<?= $input_star_id ?>" src="/pw606/img/star_<?= $input_star_value < 3 ? 'grey' : 'yellow' ?>.png" />
	<img id="4star4_<?= $input_star_id ?>" src="/pw606/img/star_<?= $input_star_value < 4 ? 'grey' : 'yellow' ?>.png" />
	<img id="5star5_<?= $input_star_id ?>" src="/pw606/img/star_<?= $input_star_value < 5 ? 'grey' : 'yellow' ?>.png" />
	<input id="<?= $input_star_id ?>" name="<?= $input_star_name ?>" value="<?= $input_star_value ?>" type="hidden" />
</div>
<?php
	if (!$input_star_readonly) {
?>
<script type="text/javascript">
	
	var <?= $input_star_id ?>_star_selected = <?= $input_star_value == -1 ? 'false' : 'true' ?>;
	
	$('1star1_<?= $input_star_id ?>').observe('mouseover', <?= $input_star_id ?>_rating_star_Over);
	$('2star2_<?= $input_star_id ?>').observe('mouseover', <?= $input_star_id ?>_rating_star_Over);
	$('3star3_<?= $input_star_id ?>').observe('mouseover', <?= $input_star_id ?>_rating_star_Over);
	$('4star4_<?= $input_star_id ?>').observe('mouseover', <?= $input_star_id ?>_rating_star_Over);
	$('5star5_<?= $input_star_id ?>').observe('mouseover', <?= $input_star_id ?>_rating_star_Over);
	
	$('1star1_<?= $input_star_id ?>').observe('mouseout', <?= $input_star_id ?>_rating_star_Out);
	$('2star2_<?= $input_star_id ?>').observe('mouseout', <?= $input_star_id ?>_rating_star_Out);
	$('3star3_<?= $input_star_id ?>').observe('mouseout', <?= $input_star_id ?>_rating_star_Out);
	$('4star4_<?= $input_star_id ?>').observe('mouseout', <?= $input_star_id ?>_rating_star_Out);
	$('5star5_<?= $input_star_id ?>').observe('mouseout', <?= $input_star_id ?>_rating_star_Out);
	
	$('1star1_<?= $input_star_id ?>').observe('click', <?= $input_star_id ?>_rating_star_click);
	$('2star2_<?= $input_star_id ?>').observe('click', <?= $input_star_id ?>_rating_star_click);
	$('3star3_<?= $input_star_id ?>').observe('click', <?= $input_star_id ?>_rating_star_click);
	$('4star4_<?= $input_star_id ?>').observe('click', <?= $input_star_id ?>_rating_star_click);
	$('5star5_<?= $input_star_id ?>').observe('click', <?= $input_star_id ?>_rating_star_click);
	
	function <?= $input_star_id ?>_rating_star_Over(event)
	{
		if (!<?= $input_star_id ?>_star_selected) {
			var star = event.element();
			var nrStar = star.id.substring(0, 1);
			<?= $input_star_id ?>_rating_star_Out(event);
			for (var i = 1; i <= parseInt(nrStar); i++)
			{
				starid = i + 'star' + i + '_<?= $input_star_id ?>';
				$(starid).src = "/pw606/img/star_yellow.png";
			}
		}
	}
	
	function <?= $input_star_id ?>_rating_star_Out(event)
	{
		if (!<?= $input_star_id ?>_star_selected) {
			$('1star1_<?= $input_star_id ?>').src = "/pw606/img/star_grey.png";
			$('2star2_<?= $input_star_id ?>').src = "/pw606/img/star_grey.png";
			$('3star3_<?= $input_star_id ?>').src = "/pw606/img/star_grey.png";
			$('4star4_<?= $input_star_id ?>').src = "/pw606/img/star_grey.png";
			$('5star5_<?= $input_star_id ?>').src = "/pw606/img/star_grey.png";
		}
	}
	
	function <?= $input_star_id ?>_rating_star_click(event)
	{
		<?= $input_star_id ?>_star_selected = !<?= $input_star_id ?>_star_selected;
		$('<?= $input_star_id ?>').value = <?= $input_star_id ?>_star_selected ? event.element().id.substring(0, 1) : '-1';
		if (!<?= $input_star_id ?>_star_selected) {
			<?= $input_star_id ?>_rating_star_Over(event);
		}
	}
	
</script>
<?php
	}
	unset($_SESSION['rating_object']);
?>