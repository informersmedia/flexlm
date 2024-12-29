<?php
	// delete the cookie
	setcookie("uuid", "", time() - 3600, "/", "", true, true);
	setcookie("permission", "", time() - 3600, "/", "", true, true);


	// redirect
	header("Location: /status");
	exit;
?>