<!DOCTYPE html>

<html>
	
	<?php

		error_reporting(0);

		$conn = mysqli_connect('localhost','root','');

		if(!$conn)
			die ("Couldn't connect to database!");

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

		$query = "SELECT * FROM userNotifications_"."$userID"." ORDER BY timeCreated DESC";
		$result = mysqli_query($conn, $query);

		$notifications = array(array());

		$i = 0;

		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$notifications[$i][0] = $row['postID'];
			$notifications[$i][1] = $row['userID'];
			$notifications[$i][2] = $row['notificationText'];
			$notifications[$i][3] = $row['seen'];

			$query = "SELECT myProfilePicture FROM globalUserTable WHERE userID='$userID'";
			$newResult = mysqli_query($conn, $query);
			$newRow = mysqli_fetch_array($result, MYSQLI_ASSOC);

			$notifications[$i][4] = $newRow['myProfilePicture'];

			$i++;
		}

		$query = "UPDATE userNotifications_"."$userID"." SET seen='1'";
		$result = mysqli_query($conn, $query);
	?>
	
	<head>
	
		<title>
			Notifications
		</title>
	
		<meta charset="utf-8">
  	
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  	
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    	<link href="https://fonts.googleapis.com/css?family=Black+Ops+One" rel="stylesheet"> 

    	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	
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
			
			h1
			{
				font-family: 'Black Ops One', cursive;
				font-size: 49px;
				text-align: left;
				background-color: rgba(100,100,100,0.5);
				padding: 25px;
				display: inline-block;
			}
		
			.background
    		{
    			position: fixed;
    			width: 100%;
    			height: 100%;
    			z-index: -1;
    		}

    		.image
    		{
    			filter: blur(3px);
    			width: 100%;
    			height: 100%;
    			opacity: 0.5;
    		}

    		.notification1
    		{
    			font-family: 'Oswald', cursive;
    			font-weight: bold;
    			font-size: 20px;
    		}

    		.notification0
    		{
    			font-family: 'Oswald', cursive;
    			font-weight: bold;
    			font-size: 20px;
    			background-color: rgba(100,200,85,0.4);
    		}

    		.notification0:hover, .notification1:hover
    		{
    			background-color: rgba(200,100,170,0.6);
    		}

    		.viewImage
    		{
    			width: 10%;
    			height: 60%;
    			border: 1px whote solid;
    		}

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

	    	.navBarTextColo
	    	{
	    		color: white;
	    	}

		</style>

	</head>

	<body onload="makeNotifications();">
	
		<div class="background">
			<img class="image" src="notifications.png" />
		</div>

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

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: black;">Notifications<i class="fa fa-caret-down"></i></a>
          
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
			
			<div class="container">
				<h1>Notifications</h1>	
			</div>

			<br />

			<div class="container" id="notifBoxes" style="border: 5px orangered solid; border-radius: 10px; background-color: rgba(255,255,255,0.3);">

				<hr />				

			</div>

		</div>

		<script type="text/javascript">
			
			function makeNotifications()
			{
				notifications = <?php echo json_encode($notifications); ?>;
				notifBoxes = document.getElementById('notifBoxes');

				for (i = 0; i < notifications.length; i++)
				{
					if (notifications[i][0] == null)
						continue;

					var notifBox = "<div class='container-fluid notification"+notifications[i][3]+"'><br /><a href='viewProfile.php?viewID="+notifications[i][1]+"'><img src='"+notifications[i][4]+"' class='viewImage' />"+notifications[i][2]+"Click <a href='postView.php?postID="+notifications[i][0]+"'>here to see post.</a><br /><br /></div></a><hr />";

					notifBoxes.innerHTML += notifBox;
				}
			}

		</script>

	</body>

</html>