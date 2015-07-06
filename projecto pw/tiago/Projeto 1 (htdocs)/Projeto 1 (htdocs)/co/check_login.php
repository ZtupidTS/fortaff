<?php
	if (!isset($_SESSION['login'])) {
		header("location: " . rootPath("co/index.php", 1));
	}
?>