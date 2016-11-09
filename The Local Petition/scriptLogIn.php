<?php
	
	$conn = mysqli_connect('localhost','root','');

	if(!$conn)
		die("Couldn't connect to the database.");

	$db = mysqli_select_db($conn, 'TheLocalPetitionDB');

	$emailID = $_POST['loginEmailID'];
	$emailID = cleanString($conn, $emailID);

	// Check if account exists

	$query = "SELECT userID,myPassword,firstName FROM globalUserTable WHERE myEmail='$emailID'";
	$result = mysqli_query($conn, $query);

	if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$password = $_POST['loginPassword'];
		$password = hash('ripemd128', $password);

		$myPassword = $row['myPassword'];

		if ($myPassword != $password)
		{
			die ("<script type='text/javascript'> alert ('Email ID or Password is incorrect!'); window.location.assign('index.html'); </script>");
		}
		else
		{
			setcookie('userID',$row['userID']);
			setcookie('userFirstName', $row['firstName']);
			header('Location: newsfeed.php');
		}
	} 
	else
	{
		die ("<script type='text/javascript'> alert ('Account with this email ID does not exists!'); window.location.assign('index.html'); </script>");
	}


	function cleanString($conn, $string)
	{
		if (get_magic_quotes_gpc())
			$string = stripslashes($string);

		$string = mysqli_real_escape_string($conn, $string);

		return htmlentities($string);	
	}

?>