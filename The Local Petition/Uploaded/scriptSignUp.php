<?php

	$conn = mysqli_connect ('localhost','id166049_tlp','123456');

	if (!$conn)
		die ("Couldn't connect to database");

	$db = mysqli_select_db ($conn, 'id166049_thelocalpetitiondb');

	$firstName = $_POST['firstName'];
	$firstName = cleanString($conn, $firstName);

	$lastName = $_POST['lastName'];
	$lastName = cleanString($conn, $lastName);

	$myLocality = $_POST['myLocality'];
	$myLocality = cleanString($conn, $myLocality);

	$myCity = $_POST['myCity'];
	$myCity = cleanString($conn, $myCity);

	$myState = $_POST['myState'];
	$myState = cleanString($conn, $myState);

	$myCountry = $_POST['myCountry'];
	$myCountry = cleanString($conn, $myCountry);

	$myPhoneNumber = $_POST['myPhoneNumber'];
	$myPhoneNumber =  cleanString($conn, $myPhoneNumber);

	$myEmail = $_POST['myEmail'];
	$myEmail = cleanString($conn, $myEmail);

	$myPassword = $_POST['myPassword'];
	$myPassword = hash('ripemd128', $myPassword);

	$myProfilePicture = "";
	$name = "";

	if ($_FILES)
	{
		$name = $_FILES['filename']['name'] + "$firstName"."'s Picture";
		move_uploaded_file($_FILES['filename']['tmp_name'], $name);
	}

	$myProfilePicture = $name;

	// To check if account already exists

	$query = "SELECT * FROM globalUserTable WHERE myEmail='$myEmail'";
	$result = mysqli_query($conn, $query);

	if (mysqli_fetch_array($result, MYSQLI_ASSOC))
		die ("<script type='text/javascript'> alert ('This email ID already exists!'); window.location.assign('index.html'); </script>");


	// To get location ID

	$query = "SELECT * FROM locationsTable WHERE locality='$myLocality'";
	$result = mysqli_query($conn, $query);

	if (!$result)
		echo "<script type='text/javascript'> alert ('This location does not exist in our database!'); window.location.assign('index.html'); </script>";

	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$myLocality = $row['locationID'];

	// For a new account

	$query = "INSERT INTO globalUserTable(firstName, lastName, myLocality, myCity, myState, myCountry, myPhoneNumber, myEmail, myPassword, myProfilePicture) VALUES ('$firstName', '$lastName', '$myLocality', '$myCity', '$myState', '$myCountry', '$myPhoneNumber', '$myEmail', '$myPassword', '$myProfilePicture')";
	$result = mysqli_query($conn, $query);

	$currentID = mysqli_insert_id($conn);

	$query = "CREATE TABLE userNewsfeed_".$currentID." LIKE userNewsfeed_Template";
	mysqli_query($conn, $query);

	$query = "CREATE TABLE userNotifications_".$currentID." LIKE userNotifications_Template";
	mysqli_query($conn, $query);
	
	header("Location: newsfeed.php");

	function cleanString($conn, $string)
	{
		if (get_magic_quotes_gpc())
			$string = stripslashes($string);

		$string = mysqli_real_escape_string($conn, $string);

		return htmlentities($string);	
	}

?>