<html>
	
	<head>

		<?php

			$conn = mysqli_connect('localhost','root','');

			if (!$conn)
				die ("Couldn't connect to the database!");

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

			if (isset($_GET['getLocation']))
			{
				addLocation($conn, $userID, $_GET['getLocation']);
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

  			function addLocation($conn, $userID, $location)
  			{
  				$query = "SELECT locationID FROM locationsTable WHERE locality='$location'";
  				$result = mysqli_query($conn, $query);
  				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  				$locationID = $row['locationID'];

  				$query = "SELECT myLocalities FROM globalUserTable WHERE userID='$userID'";
  				$result = mysqli_query($conn, $query);
  				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  				$myLocalities = $row['myLocalities'];

  				$myLocalities = explode(',', $myLocalities);
  				$myLocalities[] = $locationID;
  				$myLocalities = implode(',', $myLocalities);

  				$query = "UPDATE globalUserTable SET myLocalities='$myLocalities' WHERE userID='$userID'";
  				$result = mysqli_query($conn, $query);
  			}

		?>

		<title>
			Localities 
		</title>
    
    	<meta charset="utf-8">
    
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    
    	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    
    	<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    
    	<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    	<link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    
    	<style type="text/css">
      
      		.background-image-absolute
            {
            	filter: blur(0px);
                background-repeat: no-repeat;
                background-size: 100%;
                background-position:fixed;
            }

            #header
            {
                background-color: rgba(250, 80, 70, 1);
            }
            
            body
            {
            	font-family: "courier new";
           	}
            
            h1
            {
                font-weight: bolder;
                font-stretch: expanded;
                text-shadow: 2px 2px #ff0000;

            }
            
            #ending
            {
                background-color: black;
            }
            
            p
            {
                color:white;
                text-shadow: 2px 2px 4px #000000;
            }

    	</style>    
  
  	</head>
  
  	<body onload="setLocationsFollowing(); setLocationsNotFollowing();">
    
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

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Localities<i class="fa fa-caret-down"></i></a>
          
                            <ul class="dropdown-menu" role="menu">
        
                                <li>
                                    <a href="newsfeed.php">Home</a>
                                </li>

                                <li>
                                    <a href="myLocalities.php" disabled>Localities</a>
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
                                    <a href="createArticle.html">Create Article</a>
                                </li>

                                <li>
                                    <a href="createPetition.html">Create Petition</a>
                                </li>

                                <li>
                                    <a href="createEvent.html">Create Event</a>
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

    	<div class="background-image-absolute cover-image" style="background-image : url('better.jpeg')">
      
      		<div class="section">
        
        		<div class="container">
          
          			<div class="row">
            
            			<div class="col-md-12">
              				<h1>Localities you follow</h1>
            			</div>
          
          			</div>
        
        		</div>
      
      		</div>
      
      		<div class="section">
        
        		<div class="container">
          
          			<div class="row">
            
            			<div class="col-md-6 text-left">
              
              				<ol class="lead">
                
                				<div id="locationsFollowing">

                				</div>

              				</ol>

            			</div>

          			</div>

        		</div>
      
      		</div>

      		<div class="section">
        
        		<div class="container">
          
          			<div class="row">
            
            			<div class="col-md-6">
              				<h1 class="text-left">Localities you might know</h1>
            			</div>
          
          			</div>
        
        		</div>
      
      		</div>
      
      		<div class="section text-left">
        
        		<div class="container">
          
          			<div class="row">
            
            			<div class="col-md-12">
              
              				<ol class="lead text-left">
                
                				<div id="locationsNotFollowing">

                				</div>

              				</ol>

            			</div>

          			</div>
        
        		</div>
      
      		</div>
      
      		<div class="section" id="ending">
        
        		<div class="container">
          
          			<div class="row">
            
            			<div class="row">
              
              				<div class="col-md-12">
                
                				<p class="lead">
                					Click the plus button to follow a locality or a person in the locality.
                       				<a href="#">
                    					<i class="fa fa-check-square-o fa-fw fa-lg"></i>
                    				</a>
                    				shows that you are following the respective locality or person. To unfollow, click the same button again.
                    			</p>
              
              				</div>
            
            			</div>
          
          			</div>
        		
        		</div>
      
      		</div>
    
    	</div>
  
	    <script type="text/javascript">
	    	
	    	function setLocationsFollowing()
				{
					locationsFollowing = <?php echo json_encode($locationsFollowing); ?>;
					locationsFollowingBox = document.getElementById("locationsFollowing")

					for (i = 0; i < locationsFollowing.length; i++)
					{
						if (!locationsFollowing[i])
							continue

						var locationDiv = "<li>"+locationsFollowing[i]+"<a href='#' id='click'><i class='fa fa-fw fa-lg fa-check-square'></i></a></li>";

						locationsFollowingBox.innerHTML += locationDiv
					}
				}

				function setLocationsNotFollowing()
				{
					locationsNotFollowing = <?php echo json_encode($locationsNotFollowing); ?>;
					locationsNotFollowingBox = document.getElementById("locationsNotFollowing")

					for (i = 0; i < locationsNotFollowing.length; i++)
					{
						var locationDiv = "<li>"+locationsNotFollowing[i]+"<a href='myLocalities.php?getLocation="+locationsNotFollowing[i]+"' id='click'><i class='fa fa-fw fa-lg fa-plus-circle' onclick=\'this.className = \'fa fa-check-square-o fa-fw fa-lg\'\'></i></a></li>";

						locationsNotFollowingBox.innerHTML += locationDiv
					}
				}

	    </script>

	</body>

</html>