					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"> </div>
	<div id="footer">
		<div class="relogio">
			<span id="clockHH"><?= date("H") - 1 ?></span>:<span id="clockmm"><?= date("i") ?></span>:<span id="clockss"><?= date("s") ?></span>
			<ul>
				<li>
					<a href="<?= rootPath('public/contacts.php', 1); ?>" id="relogio">Contactos</a>
				</li>
				<li>
					<a href="/pw606/rd/index.php" id="relogio">Responsável da Delegação</a>
				</li>
				<li>
					<a href="/pw606/co/index.php">Comité Olimpico</a>
				</li>
			</ul>
		</div>
		<div class="copyright">
			PW606 &reg; 2011 TODOS OS DIREITOS RESERVADOS.
		</div>
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