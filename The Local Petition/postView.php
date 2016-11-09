<html>

<head>
 
	<?php

		$conn = mysqli_connect('localhost','root','');

		if (!$conn)
			die ("Couldn't connect to database!");

		$db = mysqli_select_db($conn, 'TheLocalPetitionDB');

		$userID = 0;

		if (isset($_COOKIE['userID']))
		{
			$userID = $_COOKIE['userID'];
		}
		else
		{
			die ("Log In to access this page!");
		}

		$postID = $_GET['postID'];

		$query = "SELECT * FROM globalNewsfeedTable WHERE postID='$postID'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$newsfeedPosts = array();
		$newRow = array();
		$newerRow = array();

		$newsfeedPosts[0] = $row['postID'];
  		$newsfeedPosts[1] = $row['timeCreated'];

  		$authorityID = $row['authorityIDTo'];

		// Get authority

		$query = "SELECT authority FROM authoritiesTable WHERE authorityID='$authorityID'";
		$newerResult = mysqli_query($conn, $query);
		$newerRow = mysqli_fetch_array($newerResult, MYSQLI_ASSOC); 

		$newsfeedPosts[4] = $newerRow['authority'];

		$locationID =  $row['localityID'];

		// Get location

		$query = "SELECT locality FROM locationsTable WHERE locationID='$locationID'";
		$newerResult = mysqli_query($conn, $query);
		$newerRow = mysqli_fetch_array($newerResult, MYSQLI_ASSOC);

		$newsfeedPosts[5] = $newerRow['locality'];

		$userIDFrom = $row['userIDFrom'];

		$query = "SELECT * FROM globalUserTable WHERE userID='$userIDFrom'";
		$result = mysqli_query($conn, $query);
		$person = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$name = $person['firstName']." ".$person['lastName'];
		$localityID = $person['myLocality'];

		$query = "SELECT locality FROM locationsTable WHERE locationID='$localityID'";
		$result = mysqli_query($conn, $query);
		$newRow = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$locality = $newRow['locality'];


	?>



    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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
            		margin-right: 1px;
            		margin-top: 5px;
            		margin-bottom: 5px;
            		
            		background: white; /* For browsers that do not support gradients */
            		background: -webkit-linear-gradient(white, #E5E5E5); /* For Safari 5.1 to 6.0 */
            		background: -o-linear-gradient(white, #E5E5E5); /* For Opera 11.1 to 12.0 */
        		    background: -moz-linear-gradient(white, #E5E5E5); /* For Firefox 3.6 to 15 */
        		    background: linear-gradient(white, #E5E5E5); /* Standard syntax */
        		    
        			   
        		}
        
        		.viewFollowers
        		{
        			margin-left: 5px;
            		margin-right: 5px;
            		margin-top: 5px;
            		background-color: white;
            		background: white; /* For browsers that do not support gradients */
            		height: 20%;
            		/*min-height: 326px;*/
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
            		font-size: 45px;
            		position: absolute;
            		top: 0%;
            		
            	}
        
            	
        
            	h1
            	{
            		color: white;
            	}
        
            	.viewPostButton
            	{
            		width: 100%;
            		height: 25%;
            		margin-top: 20px;
                    position: top;
            	}
          	
        
            	#viewPostText
            	{
            		color: black;
            		font-weight: bold;
            		z-index: 1;
            	   top: 50%;
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
        
            	.viewFollowButton
            	{
            		height: 5%;
            		font-size: 20px;
            		font-family: 'Oswald', cursive;
            		font-weight: bold;
            		margin-left: 35%;
            		margin-top: 5%;
            		margin-bottom: 5%;
            		border: 1px orangered solid;
            	}
    </style>
  </head><body style="background-color: #E5E5E5;" onload="setForEvent();">
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
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="viewPostTitle">
            	<?php echo $row['postTitle']; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section text-center">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-lg-offset-0 col-md-3 col-md-offset-0 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1" style="background-clip: border-box;border: 5px #E5E5E5 solid; background-color: white;">
            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
              <img src="emptyProfilePicture.png" style="height: 30%; width: 100%; margin-top: 25px; margin-bottom: 25px;">
            </div>
            <br>
            <div style="text-align: left;">
              <span id="name">Name: <?php echo $name; ?></span>
              <br>
              <span id="locality">Locality: <?php echo $locality; ?></span>
              <br>
              <span id="contact_number">Mobile Number: <?php echo $person['myPhoneNumber']; ?></span>
              <br>
              <span id="contact_email">Email address: <?php echo $person['myEmail']; ?></span>
              <br>
            </div>
            
          </div>
          <div class="hidden-lg hidden-md" id="emptySpaceBetweenPosts"></div>
          <div id="emptySpaceBetweenPosts"></div>
          <div class="viewPost">
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 viewPostClassHeight">
              <div id="viewPostHover">
                <p id="viewPostText">
                	<?php echo $row['postText']; ?>
                </p>
              </div>
              Post Type: <?php echo $row['postType']; ?>
              <br />
              Locality: <?php echo $newsfeedPosts[5]; ?>
              <br />
              Authority: <?php echo $newsfeedPosts[4]; ?>
              <br />
              Post was created on <i><?php echo $row['timeCreated']; ?></i>
              <br />
              <br />
              <br />

              <div id="forEvent">
              	Location of the Event: <?php echo $row['eventWhere']; ?>
              	<br/>
              	Start time: <i><?php echo $row['eventStart']; ?></i>
              	<br/>
              	End time: <i><?php echo $row['eventEnd'] ?></i>
              	<br />
              </div>

              <hr>


             </div>
            <div id="emptySpaceBetweenPosts"></div>
          </div>
          <div id="emptySpaceBetweenPosts"></div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
    	
    	function setForEvent()
    	{
    		type = <?php echo json_encode($row['postType']); ?>;
    		division = document.getElementById('forEvent');

    		if (type == "Event")
    		{
    			division.style.visibility = "visible"
    		}
    		else
    		{
    			division.style.visibility = "hidden";
    		}
    	}

    </script>
  

</body></html>