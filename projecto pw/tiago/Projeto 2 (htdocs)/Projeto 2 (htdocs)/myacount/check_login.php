<?php
	if (!isset($_SESSION['login_vs'])) {
		header("location: " . rootPath("index.php", 1));
	}
?>