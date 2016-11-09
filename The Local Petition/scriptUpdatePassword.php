<?php

	$conn = mysqli_connect('localhost','root','');

	if(!$conn)
		die ("Couldn't connect to the database!");

	$db = mysqli_select_db($conn, 'TheLocalPetitionDB');

	$userID = 0;

	if (isset($_COOKIE['userID']))
	{
		$userID = $_COOKIE['userID'];
	}
	else
	{
		die("Log In to access this page!");
	}

	$oldPassword = $_POST['myPassword'];
	$oldPassword = hash('ripemd128', $oldPassword);

	$query = "SELECT myPassword FROM globalUserTable WHERE userID='$userID'";

	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$existPassword = $row['myPassword'];

	if ($oldPassword != $existPassword)
	{
		die ("<script type='text/javascript'> alert('Old password entered is wrong!'); </script>");
	}

	$newPassword = $_POST['newPassword'];
	$newPassword = hash('ripemd128', $newPassword);

	$query = "UPDATE globalUserTable SET myPassword='$newPassword' WHERE userID='$userID'";
	$result = mysqli_query($conn, $query);

	header("Location: newsfeed.php");
?>