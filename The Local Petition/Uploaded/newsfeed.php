<html>

  	<head>

  		<?php

        // error_reporting(0);

  			$conn = mysqli_connect('localhost','id166049_tlp','123456');

  			if (!$conn)
  				die ("Couldn't connect to database");

  			$db = mysqli_select_db($conn, 'id166049_thelocalpetitiondb');

  			$userID = 0;

  			if (isset($_COOKIE['userID']))
  			{
  				$userID = $_COOKIE['userID']; 
  			}
  			else
  			{
  				die ("Log In to access your profile");
  			}

  			// Here code for liked, commented and share

  			if (isset($_GET['postIDLiked']))
  			{
  				supportBtnClicked($conn, $userID, $_GET['postIDLiked']);
  			}

  			if (isset($_GET['postIDShared']))
  			{
  				repostBtnClicked($conn, $userID, $_GET['postIDShared']);
  			}

  			if (isset($_GET['postIDCommented']))
  			{
  				remarkBtnClicked($conn, $userID, $_GET['postIDCommented'], $_GET['comment']);
  			}

  			$newsfeedPosts = array(array());

  			$query = "SELECT * FROM userNewsfeed_"."$userID"." ORDER BY timeCreated DESC";

  			$result = mysqli_query($conn, $query);

  			$i = 0;

  			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
  			{
  				$newsfeedPosts[$i][0] = $row['postID'];
  				$newsfeedPosts[$i][1] = $row['timeCreated'];
  				$newsfeedPosts[$i][2] = $row['hasSupportedGlobal'];

  				$currentID = $row['postID'];

  				// To get information from the global newsfeed

  				$query = "SELECT * FROM globalNewsfeedTable WHERE postID='$currentID'";
  				$newResult = mysqli_query($conn, $query);

  				while ($newRow = mysqli_fetch_array($newResult, MYSQLI_ASSOC))
  				{
                    $userFrom = "";

                    // get user from name

                    $userIDFrom = $newRow['userIDFrom'];
                    $newsfeedPosts[$i][17] = $userIDFrom;
                    $query = "SELECT firstName,lastName FROM globalUserTable WHERE userID='$userIDFrom'";
                    $newerResult = mysqli_query($conn, $query);
                    $newerRow = mysqli_fetch_array($newerResult, MYSQLI_ASSOC);

                    $userFrom = $newerRow['firstName']." ".$newerRow['lastName']; 

  					$newsfeedPosts[$i][3] = $userFrom;

  					$authorityID = $newRow['authorityIDTo'];

  					// Get authority

  					$query = "SELECT authority FROM authoritiesTable WHERE authorityID='$authorityID'";
  					$newerResult = mysqli_query($conn, $query);
  					$newerRow = mysqli_fetch_array($newerResult, MYSQLI_ASSOC); 

  					$newsfeedPosts[$i][4] = $newerRow['authority'];

  					$locationID =  $newRow['localityID'];

  					// Get location

  					$query = "SELECT locality FROM locationsTable WHERE locationID='$locationID'";
  					$newerResult = mysqli_query($conn, $query);
  					$newerRow = mysqli_fetch_array($newerResult, MYSQLI_ASSOC);

  					$newsfeedPosts[$i][5] = $newerRow['locality'];

  					$newsfeedPosts[$i][6] = $newRow['postType'];
  					$newsfeedPosts[$i][7] = $newRow['postTitle'];
  					$newsfeedPosts[$i][8] = $newRow['postText'];
  					$newsfeedPosts[$i][9] = $newRow['eventStart'];
  					$newsfeedPosts[$i][10] = $newRow['eventEnd'];
  					$newsfeedPosts[$i][11] = $newRow['eventWhere'];
  					$newsfeedPosts[$i][12] = $newRow['petitionClosed'];
  					$newsfeedPosts[$i][13] = $newRow['numberOfSupports'];
  					$newsfeedPosts[$i][14] = $newRow['numberOfReposts'];
  					$newsfeedPosts[$i][15] = $newRow['numberOfRemarks'];

  					$remarkers = array(array());
  						
  					$stringOfIDs = explode(',', $newRow['userIDsOfRemarkers']);
  					
  					$stringOfRemarks = explode(',', $newRow['stringOfRemarks']);

  					$j = 0;

  					foreach($stringOfIDs as $id)
  					{
  						$query = "SELECT firstName,lastName,myProfilePicture FROM globalUserTable WHERE userID='$id'";
  						$newerResult = mysqli_query($conn, $query);
  						$newerRow = mysqli_fetch_array($newerResult, MYSQLI_ASSOC);

  						$remarkers[$j][0] = $newerRow['firstName'];
  						$remarkers[$j][1] = $newerRow['lastName'];
  						$remarkers[$j][2] = $newerRow['myProfilePicture'];
  						$remarkers[$j][3] = $stringOfRemarks[$j];
  						
  						$j++;
  					}

  					$newsfeedPosts[$i][16] = $remarkers;
  				}

  				$i++;
  			}

  			$query = "SELECT myFollowing FROM globalUserTable WHERE userID='$userID'";
  			$result = mysqli_query($conn, $query);
  			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  			$followingIDs = explode(',', $row['myFollowing']);

  			$following = array(array());
  			$i = 0;

  			foreach($followingIDs as $id)
  			{
  				$query = "SELECT firstName,lastName,myProfilePicture FROM globalUserTable WHERE userID='$id'";
  				$newResult = mysqli_query($conn, $query);
  				$newRow = mysqli_fetch_array($newResult, MYSQLI_ASSOC);

  				$following[$i][0] = $newRow['firstName'];
  				$following[$i][1] = $newRow['lastName'];
  				$following[$i][2] = $newRow['myProfilePicture'];
  				
  				$i++;
  			}

  			$query = "SELECT myFollowers FROM globalUserTable WHERE userID='$userID'";
  			$result = mysqli_query($conn, $query);
  			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  			$followerIDs = explode(',', $row['myFollowers']);

  			$follower = array(array());
  			$i = 0;

  			foreach($followerIDs as $id)
  			{
  				$query = "SELECT firstName,lastName,myProfilePicture FROM globalUserTable WHERE userID='$id'";
  				$newResult = mysqli_query($conn, $query);
  				$newRow = mysqli_fetch_array($newResult, MYSQLI_ASSOC);

  				$follower[$i][0] = $newRow['firstName'];
  				$follower[$i][1] = $newRow['lastName'];
  				$follower[$i][2] = $newRow['myProfilePicture'];
  				
  				$i++;
  			}

  			$query = "SELECT myLocalities FROM globalUserTable WHERE userID='$userID'";
  			$result = mysqli_query($conn, $query);
  			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  			$locationIDs = explode(',', $row['myLocalities']);

  			$query = "SELECT myLocality FROM globalUserTable WHERE userID='$userID'";
  			$result = mysqli_query($conn, $query);
  			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  			$myLocalityID = $row['myLocality'];

  			$locationIDs[] = $myLocalityID;

  			$locationsFollowing = array();
  			$i = 0;

  			foreach($locationIDs as $id)
  			{
  				$query = "SELECT locality FROM locationsTable WHERE locationID='$id'";
  				$newResult = mysqli_query($conn, $query);
  				$newRow = mysqli_fetch_array($newResult, MYSQLI_ASSOC);

  				$locationsFollowing[$i] = $newRow['locality'];
  				
  				$i++;
  			}

  			$query = "SELECT locality FROM locationsTable WHERE ";

  			$i = 0;
  			do
  			{
  				$query .= "locationID!='$locationIDs[$i]' ";
  				$i++;

  				if ($i == sizeof($locationIDs))
  				{
  					break;
  				}
  				else
  				{
  					$query .= "AND ";
  				}
  			} while (1);

  			$result = mysqli_query($conn, $query);

  			$locationsNotFollowing = array();

  			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
  			{
  				$locationsNotFollowing[] = $row['locality'];
  			}

  			function supportBtnClicked($conn, $userID, $postID)
  			{	
  				$query = "SELECT hasSupportedGlobal FROM userNewsfeed_"."$userID"." WHERE postID='$postID'";
  				$result = mysqli_query($conn, $query);
  				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  				if ($row['hasSupportedGlobal'] == 0)
  				{
  					$query = "UPDATE userNewsfeed_"."$userID"." SET hasSupportedGlobal='1' WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);

  					$query = "SELECT numberOfSupports FROM globalNewsfeedTable WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);
  					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  					$numberOfSupports = $row['numberOfSupports'];
  					$numberOfSupports++;

  					$query = "UPDATE globalNewsfeedTable SET numberOfSupports='$numberOfSupports' WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);

  					$query = "SELECT userIDsOfRemarkers FROM globalNewsfeedTable WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);
  					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  					$userIDs = explode(',', $row['userIDsOfRemarkers']);
  					$userIDs[] = $userID;
  					$userIDs = implode(',', $userIDs);

  					$query = "UPDATE globalNewsfeedTable SET userIDsOfRemarkers='$userIDs' WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);

  					$query = "SELECT stringOfRemarks FROM globalNewsfeedTable WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);
  					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  					$remarksString = explode(',', $row['stringOfRemarks']);
  					
  					// get name of person

  					$query = "SELECT firstName,lastName FROM globalUserTable WHERE userID='$userID'";
  					$newResult = mysqli_query($conn, $query);
  					$newRow = mysqli_fetch_array($newResult, MYSQLI_ASSOC);

            		$remark = $newRow['firstName']." ".$newRow['lastName']." SUPPORTS this post.";
  					$remarksString[] = $remark;
  					$remarksString = implode(',', $remarksString);

  					$query = "UPDATE globalNewsfeedTable SET stringOfRemarks='$remarksString' WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);

		            // To the notification table of that person

		            $query = "SELECT userIDFrom FROM globalNewsfeedTable WHERE postID='$postID'";
		            $result = mysqli_query($conn, $query);
		            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		            $userIDFrom = $row['userIDFrom'];

		            $query = "INSERT INTO userNotifications_"."$userIDFrom"." (postID,userID,notificationText) VALUES ('$postID','$userID','$remark')";
		            $result = mysqli_query($conn, $query);
  				}
  				else
  				if ($row['hasSupportedGlobal'] == 1)
  				{
  					$query = "UPDATE userNewsfeed_"."$userID"." SET hasSupportedGlobal='0' WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);

  					$query = "SELECT numberOfSupports FROM globalNewsfeedTable WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  					
  					$numberOfSupports = $row['numberOfSupports'];
  					$numberOfSupports--;

  					$query = "UPDATE globalNewsfeedTable SET numberOfSupports='$numberOfSupports' WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);

  					$query = "SELECT userIDsOfRemarkers FROM globalNewsfeedTable WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);
  					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  					$userIDs = explode(',', $row['userIDsOfRemarkers']);
  					$pos = 0;
  					foreach ($userIDs as $id)
  					{
  						if ($id == $userID)
  							break;
  						
  						$pos++;
  					}

  					unset($userIDs[$pos]);
  					$userIDs = implode(',', $userIDs);

  					$query = "SELECT stringOfRemarks FROM globalNewsfeedTable WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);
  					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  					$remarksString = explode(',', $row['stringOfRemarks']);
  					unset($remarksString[$pos]);
  					$remarksString = implode(',', $remarksString);

  					$query = "UPDATE globalNewsfeedTable SET userIDsOfRemarkers='$userIDs' WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);

  					$query = "UPDATE globalNewsfeedTable SET stringOfRemarks='$remarksString' WHERE postID='$postID'";
  					$result = mysqli_query($conn, $query);
  				}
  			}

  			function repostBtnClicked($conn, $userID, $postID)
  			{
  				$query = "SELECT numberOfReposts FROM globalNewsfeedTable WHERE postID='$postID'";
  				$result = mysqli_query($conn, $query);
  				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  				$numberOfReposts = $row['numberOfReposts'];
  				$numberOfReposts++;

  				$query = "UPDATE globalNewsfeedTable SET numberOfReposts='$numberOfReposts' WHERE postID='$postID'";
  				$result = mysqli_query($conn, $query);

  				$query = "SELECT authorityIDTo,localityID,postTitle,postText,postType,petitionClosed,eventWhere,eventStart,eventEnd,postPicture FROM globalNewsfeedTable WHERE postID='$postID'";
  				$result = mysqli_query($conn, $query);
  				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  				extract($row);

  				$query = "INSERT INTO globalNewsfeedTable (userIDFrom,authorityIDTo,localityID,postTitle,postText,postType,petitionClosed,eventWhere,eventStart,eventEnd,postPicture) VALUES ('$userID','$authorityIDTo','$localityID','$postTitle','$postText','$postType','$petitionClosed','$eventWhere','$eventStart','$eventEnd','$postPicture')";
  				$result = mysqli_query($conn, $query);

  				$currentID = mysqli_insert_id($conn);

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

  				$query = "INSERT INTO userNewsfeed_"."$userID"." (postID, hasSupportedGlobal) VALUES ('$currentID','0')";
  				$result = mysqli_query($conn, $query);

  				$query = "SELECT userIDsOfRemarkers FROM globalNewsfeedTable WHERE postID='$postID'";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				$userIDs = explode(',', $row['userIDsOfRemarkers']);
				$userIDs[] = $userID;
				$userIDs = implode(',', $userIDs);

				$query = "UPDATE globalNewsfeedTable SET userIDsOfRemarkers='$userIDs' WHERE postID='$postID'";
				$result = mysqli_query($conn, $query);

				$query = "SELECT stringOfRemarks FROM globalNewsfeedTable WHERE postID='$postID'";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				$remarksString = explode(',', $row['stringOfRemarks']);
				
				// get name of person

				$query = "SELECT firstName,lastName FROM globalUserTable WHERE userID='$userID'";
				$newResult = mysqli_query($conn, $query);
				$newRow = mysqli_fetch_array($newResult, MYSQLI_ASSOC);

				$remark = $newRow['firstName']." ".$newRow['lastName']." REPOSTED this post.";

				$remarksString[] = $remark;
				$remarksString = implode(',', $remarksString);

				$query = "UPDATE globalNewsfeedTable SET stringOfRemarks='$remarksString' WHERE postID='$postID'";
				$result = mysqli_query($conn, $query);

        		// To the notification table of that person

	            $query = "SELECT userIDFrom FROM globalNewsfeedTable WHERE postID='$postID'";
	            $result = mysqli_query($conn, $query);
	            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	            $userIDFrom = $row['userIDFrom'];

	            $query = "INSERT INTO userNotifications_"."$userIDFrom"." (postID,userID,notificationText) VALUES ('$postID','$userID','$remark')";
	            $result = mysqli_query($conn, $query);
  			}

  			function remarkBtnClicked($conn, $userID, $postID, $comment)
  			{
  				$query = "SELECT userIDsOfRemarkers FROM globalNewsfeedTable WHERE postID='$postID'";
  				$result = mysqli_query($conn, $query);
  				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				$userIDs = explode(',', $row['userIDsOfRemarkers']);
				$userIDs[] = $userID;
				$userIDs = implode(',', $userIDs);

				$query = "UPDATE globalNewsfeedTable SET userIDsOfRemarkers='$userIDs' WHERE postID='$postID'";
				$result = mysqli_query($conn, $query);

				$query = "SELECT stringOfRemarks FROM globalNewsfeedTable WHERE postID='$postID'";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				$remarksString = explode(',', $row['stringOfRemarks']);
				
				// get name of person

				$query = "SELECT firstName,lastName FROM globalUserTable WHERE userID='$userID'";
				$newResult = mysqli_query($conn, $query);
				$newRow = mysqli_fetch_array($newResult, MYSQLI_ASSOC);

				$remark = $newRow['firstName']." ".$newRow['lastName']." REMARKED this post - $comment";

				$remarksString[] = $remark;
				$remarksString = implode(',', $remarksString);

				$query = "UPDATE globalNewsfeedTable SET stringOfRemarks='$remarksString' WHERE postID='$postID'";
				$result = mysqli_query($conn, $query);

				// Changing number of remarks

				$query = "SELECT numberOfRemarks FROM globalNewsfeedTable WHERE postID='$postID'";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				$numberOfRemarks = $row['numberOfRemarks'];
				$numberOfRemarks++;

				$query = "UPDATE globalNewsfeedTable SET numberOfRemarks='$numberOfRemarks' WHERE postID='$postID'";
				$result = mysqli_query($conn, $query);

				// To the notification table of that person

	            $query = "SELECT userIDFrom FROM globalNewsfeedTable WHERE postID='$postID'";
	            $result = mysqli_query($conn, $query);
	            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	            $userIDFrom = $row['userIDFrom'];

	            $query = "INSERT INTO userNotifications_"."$userIDFrom"." (postID,userID,notificationText) VALUES ('$postID','$userID','$remark')";
	            $result = mysqli_query($conn, $query);				
  			}
  		?>
  
    	<title>
    		Newsfeed
    	</title>
    
    	<meta charset="utf-8">
    
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    
    	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    
    	<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	
		<script type="text/javascript" src="/home/varun/Desktop/Bootstrap Distribution/js/bootstrap.min.js"></script>
    
    	<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">

		<link href="https://fonts.googleapis.com/css?family=Sigmar+One" rel="stylesheet">	

		<link href="css/viewProfile.css" rel="stylesheet" type="text/css">

	    <style type="text/css">

	    	#navBarMainStyle
	    	{
	    		background-color: rgba(250, 80, 70, 1);
	    		font-family: 'Oswald', sans-serif;
	       	}

	    	#navBarBrand
	    	{
	    		font-weight: bolder;
		   		color: white;
	    	}

	    	#navBarDropdown
	    	{
	    		padding-right: 10px;
	    	}

	    	.navBarTextColor
	    	{
	    		color: white;
	    	}

	    	.viewPost
	    	{
	    		margin-left: 5px;
	    		margin-right: 5px;
	    		margin-top: 5px;
	    		margin-bottom: 5px;
	    		background-color: white;
	    		border: dotted 1px grey;
	    		height: 35%;
	    		background: white; /* For browsers that do not support gradients */
	    		background: -webkit-linear-gradient(white, #E5E5E5); /* For Safari 5.1 to 6.0 */
	    		background: -o-linear-gradient(white, #E5E5E5); /* For Opera 11.1 to 12.0 */
			    background: -moz-linear-gradient(white, #E5E5E5); /* For Firefox 3.6 to 15 */
			    background: linear-gradient(white, #E5E5E5); /* Standard syntax */
			    box-shadow: 5px 5px 5px;
				transition: box-shadow 1s;
	    		-webkit-transition: box-shadow 1s;
	    		-moz-transition: box-shadow 1s;
	    		-o-transition: box-shadow 1s;
	  		}

			.viewFollowers
			{
				margin-left: 5px;
	    		margin-right: 5px;
	    		margin-top: 5px;
	    		background-color: white;
	    		background: white; /* For browsers that do not support gradients */
	    		height: 20%;
	    		background: -webkit-linear-gradient(white, #E5E5E5); /* For Safari 5.1 to 6.0 */
	    		background: -o-linear-gradient(white, #E5E5E5); /* For Opera 11.1 to 12.0 */
			    background: -moz-linear-gradient(white, #E5E5E5); /* For Firefox 3.6 to 15 */
			    background: linear-gradient(white, #E5E5E5); /* Standard syntax */
			    margin-bottom: 5px;
			}

			.viewMainPictures
			{
				padding: 5px 5px 5px 5px;
				height: 30%;
				width: 100%;
			}

			.viewPost:hover
			{
				box-shadow: 25px 25px 20px;
			}

	    	.viewPostImage
	    	{
	    		width: 100%;
	    		height: 100%;
	    		z-index: -1;
	      	}

	    	.viewPostTitle
	    	{
	    		color: black;
	    		font-family: 'Sigmar One', cursive;
	    		font-size: 35px;
	    		position: absolute;
	    		top: 40%;
	    		transition: top 1s;
	    		-webkit-transition: top 1s;
	    		-moz-transition: top 1s;
	    		-o-transition: top 1s;
	    	}

	    	.viewPostType
	    	{
	    		color: black;
	    		font-family: 'Sigmar One', cursive;
	    		font-size: 25px;
	    		position: absolute;
	    		bottom: 30%;
	    		transition: bottom 1s;
	    		-webkit-transition: bottom 1s;
	    		-moz-transition: bottom 1s;
	    		-o-transition: bottom 1s;
	    	}

	    	.viewForEvent
	    	{
	    		color: black;
	    		font-family: 'Sigmar One', cursive;
	    		font-size: 15px;
	    		position: absolute;
	    		bottom: 5%;
	    		opacity: 1;
	    		transition: opacity 1s;
	    		-webkit-transition: opacity 1s;
	    		-moz-transition: opacity 1s;
	    		-o-transition: opacity 1s;
	    	}

	    	.viewPost:hover .viewPostTitle
	    	{
	    		top: 0%;
	    	}

	    	.viewPost:hover .viewPostType
	    	{
	    		bottom: 0%;
	    	}

	    	.viewPost:hover .viewForEvent
	    	{
	    		opacity: 0;
	    	}

	    	h1
	    	{
	    		color: white;
	    	}

	      	#news
	      	{
	        	color:black;
	        	height: 100px;
	        	width: 50%;
		        display: table-cell;
		        text-align: center;
		        vertical-align: middle;
		        border-radius: 50%;
		        background-color:rgba(250, 80, 70, 0.7);
		    }

	    	.viewPostButton
	    	{
	    		width: 100%;
	    		height: 25%;
	    		margin-top: 10%;
	    	}
	  	

	    	#viewPostText
	    	{
	    		color: black;
	    		font-weight: bold;
	    		z-index: 1;
	    	}

	    	#viewPostHover
	    	{
	    		opacity: 0;
	    		margin-top: 10%;
	    		transition: opacity 1s;
				-webkit-transition: opacity 1s;
				-moz-transition: opacity 1s;
				-o-transition: opacity 1s;
				transition-delay: 0.3s;
	    		-webkit-transition-delay: 0.3s;
	    		-moz-transition-delay: 0.3s;
	    		-o-transition-delay: 0.3s;
	    		transition-timing-function: ease-in;
	    		-webkit-transition-timing-function: ease-in;
	    		-moz-transition-timing-function: ease-in;
	    	}

            .postExchange
            {
                color: black;
                font-family: 'Sigmar One', cursive;
                font-size: 15px;
                position: absolute;
                top: 5%;
                opacity: 1;
                transition: opacity 1s;
                -webkit-transition: opacity 1s;
                -moz-transition: opacity 1s;
                -o-transition: opacity 1s;
            }

            .viewPost:hover .postExchange
            {
                opacity: 0;
            }

	    	.viewPost:hover #viewPostHover
	    	{
	    		opacity: 1;
	    	}

	    	#emptySpaceBetweenPosts
	    	{
	    		height: 50px;
	    	}

	    	.viewEachFollower
	    	{
	    		text-align: center;
	    	}

	    	.viewPostClassHeight
	    	{
	    		height: 100%;
	    	}

	      	.localitiesDiv
	      	{
		        border-top: 1px black solid;
		        border-bottom: 1px black solid;
		        height: 50px;
		        font-size: 20px;
		        padding: 15px;
		        text-align: center;
		        font-family: 'Oswald', cursive;
		        color: black;
		        background-color: white;
			}

	      	.localitiesDiv:hover
	      	{
	        	background-color: skyblue;
	      	}

	      	#createNew
	        {
	            box-shadow: 10px 2px 5px;
	            transition: all 0.05s ease-in-out;
	        }
	        
            #createNew:active
            {
            	box-shadow: 5px 5px 5px;
            }

            .myModalRemark
			{
          		box-shadow: 10px 5px 5px;
              	background-color: white;
	            position: fixed;
	            top: 20%;
	            height: 50%;
	            width: 60%;
	            left: 20%;
	            border: 2px black solid;
	            opacity: 1;
	            z-index: 4;
	            padding: 15px;
            }

            #remarksModal
            {
              	visibility: hidden;
            }

            .oneRemark
            {
              	margin: 10px;
            }

            .createText
            {
		        position: relative; 
		        top: 0%; 
		        left: 0%; 
		        margin: 20px; 
		        font-size: 60px; 
		        width: 30%; 
		        text-align: center;
		        color: white;
		        font-family: 'Oswald', cursive;
            }

	    </style>

        <title>
            Home
        </title>

  	</head>
  
  	<body style="background-color: #E5E5E5;" onload="makeNewsfeed(); setFollowing(); setFollower(); setLocationsFollowing(); setLocationsNotFollowing();">
    
    	<div class="navbar navbar-default navbar-static-top" id="navBarMainStyle">
        
            <div class="container">
    
                <div class="navbar-header">
      
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="#"><span id="navBarBrand">TLP</span></a>
    
                </div>
   
                <div class="collapse navbar-collapse" id="navbar-ex-collapse">
      
                    <ul class="nav navbar-nav navbar-left">
        
                        <li class="dropdown" id="navBarDropdown">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Home<i class="fa fa-caret-down"></i></a>
          
                            <ul class="dropdown-menu" role="menu">
        
                                <li>
                                    <a href="newsfeed.php">Home</a>
                                </li>

                                <li>
                                    <a href="myLocalities.php">Localities</a>
                                </li>

                                <li>
                                    <a href="myPeople.php">People</a>
                                </li>

                                <li>
                                    <a href="myProfile.php">My Profile</a>
                                </li>

                                <li class="divider">
                                </li>
                                
                                <li>
                                    <a href="createArticle.php">Create Article</a>
                                </li>

                                <li>
                                    <a href="createPetition.php">Create Petition</a>
                                </li>

                                <li>
                                    <a href="createEvent.php">Create Event</a>
                                </li>

                            </ul>
    
                        </li>
      
                    </ul>
      
                    <ul class="nav navbar-nav navber-center" style="width: 50%;">
                        <form action='search.php' method="GET" style="display: inline;">
                            <input type="text" name="search" placeholder="Search for petitions, articles, events, or more..." style="margin-top: 10px; height: 30px; width: 100%;" >
                        </form>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a href="myProfile.php"><span class="navBarTextColor">Hey, <?php echo $_COOKIE['userFirstName']; ?></span></a>
                        </li>

                        <li>
                            <a href="notifications.php"><span class="navBarTextColor">Notifications</span></a>
                        </li>
        
                        <li>
                            <a href="settings.php"><span class="navBarTextColor">Settings</span></a>
                        </li>

                        <li class="navBarTextColor">
                            <a href="scriptLogOut.php"><span class="navBarTextColor">Log Out</span></a>
                        </li>
      
                    </ul>
    
                </div>
  
            </div>

        </div>
    
    	<div class="section">
      
      		<div class="container-fluid">
        
        		<div class="row">             
          
          			<div class="col-lg-3 col-lg-offset-0 col-md-3 col-md-offset-0 col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0" style="background-color: white; padding: 25px;">
            
            			<br />
            			<div id="locationsFollowing">
	            			
	            			<h2 style="color:black;font-family:'Oswald', cursive"> Localities you follow </h2>
	                        			
          				</div>

          				<div id="emptySpaceBetweenPosts">
                  		</div>

                  		<div id="emptySpaceBetweenPosts">
                  		</div>

                  		<div id="emptySpaceBetweenPosts">
                  		</div>

          				<div id="locationsNotFollowing">
	            			
	            			<h2 style="color:black;font-family:'Oswald', cursive"> Localities you could follow </h2>
	           
          				</div>

          			</div>

         	        <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0"> 
            
              			<h1 id="news" style="font-family:'Oswald';color:black; position: relative; left: 10%; "> My News feed </h1>
              
                 		<div id="emptySpaceBetweenPosts">
                  		</div>

                  		<div style="text-align: center;">

                  			<a href="createArticle.php">
	                 			<div class="viewPost" id="createNew" style="width: 30%; display: inline-block; background: #604D75; background-size: 100% 100%; border: 5px white solid;">
	                       			<div class="createText">Create article</div>
	                  			</div>
              				</a>

              				<a href="createPetition.php">
	                  			<div class="viewPost" id="createNew" style="width: 30%; display: inline-block; background: #55837D; background-size: 100% 100%; border: 5px white solid;">
	                      			<div class="createText">Create petition</div>
	                  			</div>
            				</a>

            				<a href="createEvent.php">
	            				<div class="viewPost" id="createNew" style="width: 30%; display: inline-block; background: #817253; background-size: 100% 100%; border: 5px white solid;">
	                      			<div class="createText">Create event</div>
	                  			</div>
                  			</a>

                  		</div>
            
                  		<div id="emptySpaceBetweenPosts">
                  		</div>

                  		<div class="myModalRemark" id="remarksModal"> 

                  			<div id="remarksHeading" style="position:absolute; left: 5px;font-family: 'Oswald', cursive; font-weight: bold; font-size: 20px;">
                  				Remarks
                  			</div>

                        	<button style="position:absolute; right: 5px;" onclick="closeRemarks();">Close</button>
                        	<br />
                        	
                        	<hr />

                        	<div id="remarksPost" style="height: 70%; overflow-y: scroll;">

							</div>

                        	<hr />

	                        <div>
	                        	<form action="newsfeed.php" method="GET">
		                        	<input type="hidden" name="postIDCommented" id="hiddenPostID" />
		                        	<input name="comment" type="text" style="width: 80%;" placeholder="Remark on this post." />
		                          	<input type="submit" style="width: 19%;" value="Post Remark" />
	                        	</form>
	                        </div>

                    	</div>

                    	<div id="postBoxes">

                  		</div>

                	</div>             
            
                	<div class="col-lg-3 col-lg-offset-0 col-md-3 col-md-offset-0 col-sm-10 col-sm-offset-1 col-xs-12">
          	
          				<div class="viewFollowers" id="follower">
          	
          					<h3> Followers </h3>
          
          				</div>

          				<div id="emptySpaceBetweenPosts">
          				</div>
          				
          				<div id="emptySpaceBetweenPosts">
          				</div>
          				
          				<div id="emptySpaceBetweenPosts">
          				</div>

          				<div class="viewFollowers" id="following">
          	
          					<h3> Following </h3>

          				</div>

          				<div id="emptySpaceBetweenPosts">
          				</div>

          			</div>
        
        		</div>
      
      		</div>
    
    	</div>

    	<script type="text/javascript">

			newsfeedPosts = <?php echo json_encode($newsfeedPosts); ?>;
		
			function makeNewsfeed()
			{
				postBoxes = document.getElementById('postBoxes');

				for (i = 0; i < newsfeedPosts.length; i++)
				{

                    if (newsfeedPosts[i][8] == null)
                        continue;

					var smallText = ""

					for (i0 = 0; ((i0 < newsfeedPosts[i][8].length) && (i0 < 200)); i0++)
					{
						smallText += newsfeedPosts[i][8][i0]
					}
					
					if (newsfeedPosts[i][8] > 200)
					{
						smallText += "..."
					}

					// To check if liked already

					hasSupportedGlobal = "<a href='newsfeed.php?postIDLiked="+newsfeedPosts[i][0]+"'><button class='btn btn-success viewPostButton'>Support<br>"+newsfeedPosts[i][13]+"</button></a>"

					if (newsfeedPosts[i][2] == 1)
					{
						hasSupportedGlobal = "<a href='newsfeed.php?postIDLiked="+newsfeedPosts[i][0]+"'><button class='btn btn-primary viewPostButton'>Unsupport<br>"+newsfeedPosts[i][13]+"</button></a>"
					}

					// For event to display eventWhere, eventDuration

					var forEvent = ""

					if (newsfeedPosts[i][6] == "Event")
					{
						forEvent = "<div class='viewForEvent'>Location: "+newsfeedPosts[i][11]+"<br />Starts at: "+newsfeedPosts[i][9]+"<br />Ends at: "+newsfeedPosts[i][10]+"</div>"
					}

					var postBox ="<div class='viewPost'><div class='col-lg-9 col-md-9 col-sm-9 col-xs-9 viewPostClassHeight'><div class='postExchange'>"+"<a href='viewProfile.php?viewID="+newsfeedPosts[i][17]+"'>"+newsfeedPosts[i][3]+"</a><b> &gt </b> "+newsfeedPosts[i][5]+" "+newsfeedPosts[i][4]+"</div><div class='viewPostTitle'>"+newsfeedPosts[i][7]+"</div><div class='viewPostType'>"+newsfeedPosts[i][6]+"</div>"+forEvent+"<div id='viewPostHover'><p id='viewPostText'>"+smallText+"</p><a href='postView.php?postID="+newsfeedPosts[i][0]+"'>Click here to read more</a></div></div><div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>"+hasSupportedGlobal+"<button class='btn btn-info viewPostButton' onclick='viewRemarks("+i+");'>Remark<br>"+newsfeedPosts[i][15]+"</button><a href='newsfeed.php?postIDShared="+newsfeedPosts[i][0]+"'><button class='btn btn-danger viewPostButton'>Repost<br>"+newsfeedPosts[i][14]+"</button></a></div></div><div id='emptySpaceBetweenPosts'></div>"

					postBoxes.innerHTML += postBox

				}
			}

			function setFollowing()
			{
				following = <?php echo json_encode($following); ?>;
				followingBoxes = document.getElementById("following");

				for (i = 0; ((i < following.length) && (i < 8)); i++)
				{
					var followingBox = "<div class='col-lg-3 col-md-4 col-sm-6 col-xs-6 viewEachFollower'><img src='"+following[i][2]+"' class='viewMainPictures' />"+following[i][0]+" "+following[i][1]+"</div>"

					followingBoxes.innerHTML += followingBox
				}
			}

			function setFollower()
			{
				follower = <?php echo json_encode($follower); ?>;
				followerBoxes = document.getElementById("follower");

				for (i = 0; ((i < follower.length) && (i < 8)); i++)
				{
					var followerBox = "<div class='col-lg-3 col-md-4 col-sm-6 col-xs-6 viewEachFollower'><img src='"+follower[i][2]+"' class='viewMainPictures' />"+follower[i][0]+" "+follower[i][1]+"</div>"

					followerBoxes.innerHTML += followerBox
				}
			}

			function setLocationsFollowing()
			{
				locationsFollowing = <?php echo json_encode($locationsFollowing); ?>;
				locationsFollowingBox = document.getElementById("locationsFollowing")

				for (i = 0; i < locationsFollowing.length; i++)
				{
					if (!locationsFollowing[i])
						continue

					var locationDiv = "<div class='localitiesDiv'>"+locationsFollowing[i]+"</div>"

					locationsFollowingBox.innerHTML += locationDiv
				}
			}

			function setLocationsNotFollowing()
			{
				locationsNotFollowing = <?php echo json_encode($locationsNotFollowing); ?>;
				locationsNotFollowingBox = document.getElementById("locationsNotFollowing")

				for (i = 0; i < locationsNotFollowing.length; i++)
				{

					var locationDiv = "<div class='localitiesDiv'>"+locationsNotFollowing[i]+"</div>"

					locationsNotFollowingBox.innerHTML += locationDiv
				}
			}

			function viewRemarks(pos) 
          	{
            	var modalRemark = document.getElementById("remarksModal")
            	var remarkBoxes = document.getElementById("remarksPost")

            	remarkBoxes.innerHTML = ""

            	remarks = newsfeedPosts[pos][16]

            	for (i = 0; i < remarks.length; i++)
            	{
                if (remarks[i][0] == null)
                  continue

            		if (remarks[i][3] != "")
            		{
            			var remarkBox = "<div class='oneRemark'><img src='"+remarks[i][2]+"' style='height: 20%; width: 10%;' />"+remarks[i][3]+"</div>"
	            	
	            		remarkBoxes.innerHTML += remarkBox
	           		}

	            }

	            var hiddenPostID = document.getElementById("hiddenPostID")

	            hiddenPostID.value = newsfeedPosts[pos][0]

            	modalRemark.style.visibility = "visible" 
          	}

          	function closeRemarks()
          	{
            	var modalRemark = document.getElementById("remarksModal")
            	modalRemark.style.visibility = "hidden"
          	}

		</script>

    </body>	

</html>