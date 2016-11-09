<?php

	setcookie('userID',0, time() - 2512000);
	setcookie('userFirstName',"0", time() - 2512000);
	header("Location: index.html");

?>