<?php

	$conn = mysqli_connect('localhost','root','');

	if (!$conn)
		die ("Couldn't connect");

	$db = mysqli_select_db($conn, 'TheLocalPetitionDBDuplicate');

	$authorities = array("Police","Hospital","BWSSB","BDA","BESCOM");

	foreach($authorities as $authority)
	{
		$query = "INSERT INTO authoritiesTable(authority) VALUES ('$authority')";
		mysqli_query($conn, $query);
	}

?>
