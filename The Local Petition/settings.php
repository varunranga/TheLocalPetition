<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	  <!--<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald" />-->
	  <style type="text/css">
	  	body{
	  		background-image: url("Setting.png"); 
	  		background-repeat: no-repeat;
	  		background-position: center;
	  		background-size: cover;
	  		
	  	}
	  	.main{
	  		padding-left: 40%;
	  		padding-top: 3%;
	  	}
	  	h1{
	  		font-family: Oswald;
			font-size: 48px;
			font-style: normal;
			font-variant: normal;	
			margin: 1em 0 0.5em 0;
			font-weight: normal;
			position: relative;
			text-shadow: 0 -1px rgba(0,0,0,0.6);
			font-size: 40px;
			line-height: 40px;
			background: #355681;
			background: rgba(53,86,129, 0.8);
			border: 1px solid #fff;
			padding: 5px 15px;
			color: white;
			border-radius: 0 10px 0 10px;
			box-shadow: inset 0 0 5px rgba(53,86,129, 0.5);	
			padding-left: 2%;
			padding-right: 2%;
			text-align: center;
		  	}
	  	#clk{
	  		 font-size: 24px;
	  		 line-height: 40px;
	  		 padding: 12px 12px 12px 12px;
	  	}
	  </style>
	  <script type="text/javascript">
	  	function previewFile(){
       var preview = document.querySelector('img'); //selects the query named img
       var file    = document.querySelector('input[type=file]').files[0]; //sames as here
       var reader  = new FileReader();

       reader.onloadend = function () {
           preview.src = reader.result;
       }

       if (file) {
           reader.readAsDataURL(file); //reads the data as a URL
       } else {
           preview.src = "";
       }
  }

  previewFile();
	  </script>
</head>
<body>
	<div class="container-fluid">
		<h1>Settings</h1>
	    <div class="main">
	   		<div class="btn-group-vertical">
	   			<br/>
	   			<a href="uploadImage.html" class="btn btn-primary" role="button" id="clk">Update Profile Picture</a>
	   			<a href="UpdatePassword.html" class="btn btn-primary" role="button" id="clk">Update Password</a>
    			<a href="UpdateInformation.html" class="btn btn-primary" role="button" id="clk">Update Information</a> 
      		</div>
  		</div>
	</div>
</body>
</html>