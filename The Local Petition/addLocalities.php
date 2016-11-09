<?php

	$conn = mysqli_connect('localhost','root','');

	if (!$conn)
		die ("Couldn't connect");

	$db = mysqli_select_db($conn, 'TheLocalPetitionDBDuplicate');

	$areas = array("Airport Area","Airport Road","Banashankari","Banaswadi","Bannerghatta Road","Basavanagudi","Basaveshwaranagar","Bommanahalli","BTM Layout","C V Raman Nagar","Chamarajpet","Chikkajala","Cox Town","Devanahalli","Domlur","Electronic City","Hanumanth Nagar","Hebbal","Hennur","Horamavu","Hoskote","Hosur Road","HSR Layout","Indira Nagar","Jakkur","Jalahalli","Jayanagar","Jeevan Bima Nagar","JP Nagar","Kalyan Nagar","Kanakapura Road","Kengeri","Koramangala","KR Puram","Kumaraswamy Layout","Kundalahalli","Madiwala","Magadi Road","Majestic","Malleshwaram","Marathahalli","Mathikere","MG Road","Mysore Road","Nagarbhavi","Nagawara","Old Airport Road","OMBR Layout","Padmanabhanagar","Peenya","Rajajinagar","Rajarajeshwari Nagar","Ramamurthy Nagar","Richmond Road","RT Nagar","Sahakar Nagar","Sanjay Nagar","Sarjapur","Shanti Nagar","Thippasandra","Tippasandra","Ulsoor","Uttarahalli","Vidyanagar","Vijaya Bank Layout","Vijayanagar","Whitefield","Yelahanka","Yeshwantpur");

	foreach($areas as $area)
	{
		$query = "INSERT INTO locationsTable(locality) VALUES ('$area')";
		mysqli_query($conn, $query);
	}

?>
