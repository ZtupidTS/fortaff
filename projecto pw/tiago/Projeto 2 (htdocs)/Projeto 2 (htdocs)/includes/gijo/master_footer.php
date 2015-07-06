					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"> </div>
	<div id="footer">
		<span id="clockHH"><?= date("H") - 1 ?></span>:<span id="clockmm"><?= date("i") ?></span>:<span id="clockss"><?= date("s") ?></span>
		<a>PW606 &reg; 2011 TODOS OS DIREITOS RESERVADOS.</a>
	</div>
	<script type="text/javascript">
		updateJoDate();
		updateClock();
	</script>
</body>
</html>
<?php
	closeDataBase();
?>