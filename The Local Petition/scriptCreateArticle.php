<?php
	
	$conn = mysqli_connect('localhost','root','');

	if (!$conn)
		die ("Couldn't connect to database");

	$userID = $_COOKIE['userID'];

	$db = mysqli_select_db($conn, 'TheLocalPetitionDB');

	$userIDFrom = $userID;

	$authority = $_POST['authority'];
	$authority = cleanString($conn, $authority);

	$authorityIDTo = 0;

	$locality = $_POST['locality'];
	$locality = cleanString($conn, $locality);

	// Check if the authority exists

	$query = "SELECT authorityID FROM authoritiesTable WHERE authority='$authority'";
	$result = mysqli_query($conn, $query);

	if (!$result)
		die ("<script type='text/javascript'> alert ('Authority does not exist in our database!'); window.location.assign('createArticle.html'); </script>");

	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$authorityIDTo = $row['authorityID'];

	// Check if the locality exists

	$query = "SELECT * FROM locationsTable WHERE locality='$locality'";
	$result = mysqli_query($conn, $query);

	if (!$result)
		echo "<script type='text/javascript'> alert ('This location does not exist in our database!'); window.location.assign('index.html'); </script>";

	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$localityID = $row['locationID'];

	$postTitle = $_POST['articleTitle'];
	$postTitle = cleanString($conn, $postTitle);

	$postText = $_POST['articleText'];
	$postText = cleanString($conn, $postText);

	$postType = "Article";

	$postPicture = "";
	$name = "";

	if ($_FILES)
	{
		$name = $_FILES['filename']['name'] + "$firstName"."'s Picture";
		move_uploaded_file($_FILES['filename']['tmp_name'], $name);
	}

	$postPicture = $name;

	$query = "INSERT INTO globalNewsfeedTable (userIDFrom, authorityIDTo, localityID, postTitle, postText, postType, postPicture) VALUES ('$userIDFrom', '$authorityIDTo', '$localityID', '$postTitle', '$postText', '$postType', '$postPicture')";
	$result = mysqli_query($conn, $query);

	$currentID = mysqli_insert_id($conn);

	// To add to newsfeeds of followers of userID

	$query = "SELECT myFollowers FROM globalUserTable WHERE userID='$userID'";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$followers = explode(',',$row['myFollowers']);

	$hasSupportedGlobal = 0;

	foreach ($followers as $followerID)
	{

		$query = "INSERT INTO userNewsfeed_"."$followerID"." (postID, hasSupportedGlobal) VALUES ('$currentID', '$hasSupportedGlobal')";
		mysqli_query($conn, $query);
	}

	$query = "INSERT INTO userNewsfeed_"."$userID"." (postID, hasSupportedGlobal) VALUES ('$currentID', '$hasSupportedGlobal')";
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