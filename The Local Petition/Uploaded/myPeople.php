<html>

	<head>

		<?php

			$conn = mysqli_connect('localhost','id166049_tlp','123456');

			if (!$conn)
				die("Couldn't connect to the database!");

			$userID = 0;

			if (isset($_COOKIE['userID']))
			{
				$userID = $_COOKIE['userID'];
			}
			else
			{
				die ("Log In to access this page!");
			}

			$db = mysqli_select_db($conn, 'id166049_thelocalpetitiondb');

	      	$query = "SELECT myFollowing FROM globalUserTable WHERE userID='$userID'";
	        $result = mysqli_query($conn, $query);
	        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	        $followingIDs = explode(',', $row['myFollowing']);

	        $following = array(array());
	        $i = 0;

	        foreach($followingIDs as $id)
	        {
	            $query = "SELECT userID,firstName,lastName,myProfilePicture FROM globalUserTable WHERE userID='$id'";
	            $newResult = mysqli_query($conn, $query);
	            $newRow = mysqli_fetch_array($newResult, MYSQLI_ASSOC);

	          	$following[$i][0] = $newRow['firstName'];
	          	$following[$i][1] = $newRow['lastName'];
	          	$following[$i][2] = $newRow['myProfilePicture'];
	          	$following[$i][3] = $newRow['userID'];
	          
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
	          	$query = "SELECT userID,firstName,lastName,myProfilePicture FROM globalUserTable WHERE userID='$id'";
	          	$newResult = mysqli_query($conn, $query);
	          	$newRow = mysqli_fetch_array($newResult, MYSQLI_ASSOC);

	          	$follower[$i][0] = $newRow['firstName'];
	          	$follower[$i][1] = $newRow['lastName'];
	          	$follower[$i][2] = $newRow['myProfilePicture'];
	          	$follower[$i][3] = $newRow['userID'];

	          
	          	$i++;
	        }

	        // Get user locality

	        $query = "SELECT myLocality FROM globalUserTable WHERE userID='$userID'";
	        $result = mysqli_query($conn, $query);
	        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	        $userLocality = $row['myLocality'];

	        $query = "SELECT userID,firstName,lastName,myProfilePicture FROM globalUserTable WHERE myLocality='$userLocality' AND ";

	        $i = 0;

	        do
	        {
	        	if ($i == (sizeof($following) - 1))
	        	{
	        		$tempID = $following[$i][3];
	        		$query .= "userID='$tempID' AND ";
	        		
	        		$i++;
	        	}
	        	else
	        	{
	        		$query .= "1";
	        		break;
	        	}
	        } while (1);

	        $result = mysqli_query($conn, $query);

	        $other = array(array());

	        $i = 0;

	        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	        {
	        	$other[$i][0] = $newRow['firstName'];
	          	$other[$i][1] = $newRow['lastName'];
	          	$other[$i][2] = $newRow['myProfilePicture'];
	          	$other[$i][3] = $newRow['userID'];
	          
	          	$i++;
	        }

		?>
    
    	<meta charset="utf-8">
    
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    
    	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    
    	<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    
    	<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    	<link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">

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
            
            #followers
            {
                background-color:rgba(240, 255, 240, 0.4);
            }

            #picture
            {
            	border: 1px black solid;
            	width: 100%; 
            	height: 120px;
            }

    	</style>

        <title>
            People
        </title>

  	</head>

  	<body style="background-color:#87CEFA" onload="setFollowers(); setFollowings(); setOthers();">
    
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

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My People<i class="fa fa-caret-down"></i></a>
          
                            <ul class="dropdown-menu" role="menu">
        
                                <li>
                                    <a href="newsfeed.php">Home</a>
                                </li>

                                <li>
                                    <a href="myLocalities.php">Localities</a>
                                </li>

                                <li>
                                    <a href="myPeople.php" disabled>People</a>
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
        
        		<div class="row" id="followers">
          
          			<div class="col-md-12">
          
          				<div id="followersDiv">

        					<h1 class="text-center" style="text-shadow: 2px 2px #ff0000">People you are following</h1>
        
        					<br />
        
        				</div>
        
        			</div>
        
        		</div>

        	</div>

        	<br />
    
    		<div class="container">
        
        		<div class="row" id="followers">
          
          			<div class="col-md-12">
          
          				<div id="followingsDiv">

          					<h1 class="text-center" style="text-shadow: 2px 2px #ff0000">People who follow you</h1>
        
        					<br />
        
        				</div>

          			</div>

          		</div>

          	</div>

          	<br />
    
    		<div class="container">
        
        		<div class="row" id="followers">
          
          			<div class="col-md-12">
          
          				<div id="othersDiv">

          					<h1 class="text-center" style="text-shadow: 2px 2px #ff0000">Others in your locality</h1>
        
        					<br />
        
        				</div>

          			</div>

          		</div>

          	</div>
       
    	</div>

    	<script type="text/javascript">
    		
    		function setFollowers()
    		{
    			followers = <?php echo json_encode($follower); ?>;
    			followersBoxes = document.getElementById("followersDiv")

    			for (i = 0; i < followers.length; i++)
    			{
    				if (followers[i][0] == null)
    					continue;

    				var followerBox = "<div class='col-md-2'><a href='viewProfile.php?viewID="+followers[i][3]+"'><img src='"+followers[i][2]+"' id='picture'></a><h2><a href='viewProfile?viewID="+followers[i][3]+"'>"+followers[i][0]+" "+followers[i][1]+"</a></h2></div>"

    				followersBoxes.innerHTML += followerBox
    			}
    		}

    		function setFollowings()
    		{
    			followings = <?php echo json_encode($following); ?>;
    			followingsBoxes = document.getElementById("followingsDiv")

    			for (i = 0; i < followings.length; i++)
    			{
    				if (followings[i][0] == null)
    					continue;

    				var followingBox = "<div class='col-md-2'><a href='viewProfile.php?viewID="+followings[i][3]+"'><img src='"+followings[i][2]+"' id='picture'></a><h2><a href='viewProfile?viewID="+followings[i][3]+"'>"+followings[i][0]+" "+followings[i][1]+"</a></h2></div>"

    				followingsBoxes.innerHTML += followingBox
    			}
    		}

    		function setOthers()
    		{
    			others = <?php echo json_encode($other); ?>;
    			othersBoxes = document.getElementById("othersDiv")

    			for (i = 0; i < others.length; i++)
    			{
    				if (others[i][0] == null)
    					continue;

    				var otherBox = "<div class='col-md-2'><a href='viewProfile.php?viewID="+others[i][3]+"'><img src='"+others[i][2]+"' id='picture'></a><h2><a href='viewProfile?viewID="+others[i][3]+"'>"+others[i][0]+" "+others[i][1]+"</a></h2></div>"

    				othersBoxes.innerHTML += otherBox
    			}
    		}

    	</script>
  	
  	</body>

</html>