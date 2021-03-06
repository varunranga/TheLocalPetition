<!DOCTYPE html>

<html>

	<head>
	
		<title>
			Create petition
		</title>
	
		<meta charset="utf-8">
  	
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  	
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
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

			body
			{
				background-color: #604D75;
			}	

			#petitionHeader
			{
				margin-top: 20px;
				font-family: cursive;
				font-weight: bolder;
				font-size: 72px;
				color: black;
				text-shadow: 5px 5px 5px;
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
		
		</style>

	</head>

	<body>
	
		<div class="background">
			<img class="image" src="petition.jpg" />
		</div>

		<div class="section">
		
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

              					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Create Petition<i class="fa fa-caret-down"></i></a>
              
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
		
			<div class="container">
			
				<div id="petitionHeader">
					Create a new petition
				</div>
		
			</div>
		
			<div class="container" style="border: 10px #55837D solid; border-radius: 10px; height: 100%; padding: 20px;">
				
				<form action="scriptCreatePetition.php" method="POST" enctype="multipart/form_data">
				
					<label for="authority" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px;">Authority</label>
					<input type="text" name="authority" style="border-collapse: collapse; width: 70%" />
					<br />
				
					<label for="locality" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px;">Locality</label>
					<input type="text" name="locality" style="border-collapse: collapse; width: 70%" />
					<br />
				
					<label for="petitionTitle" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px;">Petition Title</label>
					<input type="text" name="petitionTitle" style="border-collapse: collapse; width: 70%" />
					<br />
        
        			<br />
				
					<label for="petitionText" style="width: 100%; text-align: left; font-family: 'Oswald', cursive; padding: 10px; ">Write your petition description here</label>
					<br />
				
					<textarea name="petitionText" style="border-collapse: collapse; padding: 10px; width: 100%; line-height: 1; height: 350px; "></textarea>
					<br />
				
					<br />
			        
			        <label for="petitionPicture" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px; color: white;">Upload a picture</label>
			        <input type="file" name="petitionPicture" />
			        <br />
				
					<br />
				
					<div style="text-align: right;">
						<input class="btn btn-md btn-info" type="submit" name="submitPetition" value="Create Petition" style="padding: 30px;" />
					</div>
			
				</form>
		
			</div>		
	
		</div>
	
	</body>

</html>