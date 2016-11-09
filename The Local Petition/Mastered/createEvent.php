<!DOCTYPE html>

<html>

  	<head>
	
    	<title>
    		Create event
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

			#monthStartID, #daysOfMonthStart, #hoursStartID, #minuteStartID, #monthEndID, #daysOfMonthEnd, #hoursEndID, #minuteEndID
			{
				visibility: hidden;
			}

		</style>
	
	</head>

	<body>
	
		<div class="background">
			<img class="image" src="protest.jpg" />
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

              					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Create Event<i class="fa fa-caret-down"></i></a>
              
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
					Create a new event
				</div>
		
			</div>
		
			<div class="container" style="border: 10px #55837D solid; border-radius: 10px; height: 100%; padding: 20px;">
			
				<form action="scriptCreateEvent.php" method="POST" enctype="multipart/form_data">

					<label for="authority" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px;">Authority</label>
					<input type="text" name="authority" style="border-collapse: collapse; width: 70%" />
					<br />
					
					<label for="locality" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px;">Locatlity</label>
					<input type="text" name="locality" style="border-collapse: collapse; width: 70%" />
					<br />
				
					<label for="eventTitle" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px;">Event Title</label>
					<input type="text" name="eventTitle" style="border-collapse: collapse; width: 70%" />
					<br />

					<label for="eventWhere" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px;">Location of event</label>
					<input type="text" name="eventWhere" style="border-collapse: collapse; width: 70%" />
					<br />
				
					<label for="eventStart" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px;">Event Start</label>
						
					<select name="yearStart" onchange="monthStartDisplay();">
			          
			        	<option value="">Select Year</option>
			        	<option value="2016">2016</option>
			        	<option value="2017">2017</option>
			        	<option value="2018">2018</option>
			          	<option value="2019">2019</option>
			          	<option value="2020">2020</option>
			          	<option value="2021">2021</option>
			          	<option value="2022">2022</option>
			          	<option value="2023">2023</option>
			          	<option value="2024">2024</option>
			          	<option value="2025">2025</option>
			          	<option value="2026">2026</option>
    				</select>

			        <select name="monthStart" id="monthStartID" onchange="addDaysStart(monthStart.value, yearStart.value);">

			          	<option value="">Select Month</option>
			          	<option value="01">January</option>
				        <option value="02">Febraury</option>
				        <option value="03">March</option>
				        <option value="04">April</option>
				        <option value="05">May</option>
				        <option value="06">June</option>
				        <option value="07">July</option>
				        <option value="08">August</option>
				        <option value="09">September</option>
				        <option value="10">October</option>
				        <option value="11">November</option>
				        <option value="12">December</option>   

			        </select>

    				<select id="daysOfMonthStart" name="dateStart" onchange="hoursStartDisplay();">

    					<option value="">Select Date</option>

    				</select>

    				<select id="hoursStartID" name="hoursStart" onchange="minuteStartDisplay();">

			          	<option value="">Select Hour</option>
			          	<option value="00">12 midnight</option>
				        <option value="01">1 am</option>
				        <option value="02">2 am</option>
				        <option value="03">3 am</option>
				        <option value="04">4 am</option>
				        <option value="05">5 am</option>
				        <option value="06">6 am</option>
				        <option value="07">7 am</option>
				        <option value="08">8 am</option>
				        <option value="09">9 am</option>
				        <option value="10">10 am</option>    
				        <option value="11">11 am</option>  
				        <option value="12">12 noon</option>
				        <option value="13">1 pm</option>
				        <option value="14">2 pm</option>
				        <option value="15">3 pm</option>
				        <option value="16">4 pm</option>
				        <option value="17">5 pm</option>
				        <option value="18">6 pm</option>
				        <option value="19">7 pm</option>
				        <option value="20">8 pm</option>
				        <option value="21">9 pm</option>
				        <option value="22">10 pm</option>    
				        <option value="23">11 pm</option>  

    				</select>

    				<select id="minuteStartID" name="minuteStart">

				        <option value="">Select Minute</option>
				        <option value="00">00</option> 
				        <option value="01">01</option>
				        <option value="02">02</option>
				        <option value="03">03</option>
				        <option value="04">04</option>
				        <option value="05">05</option>
				        <option value="06">06</option>
				        <option value="07">07</option>
				        <option value="08">08</option>
				        <option value="09">09</option>
				        <option value="10">10</option> 
				        <option value="11">11</option>
				        <option value="12">12</option>
				        <option value="13">13</option>
				        <option value="14">14</option>
				        <option value="15">15</option>
				        <option value="16">16</option>
				        <option value="17">17</option>
				        <option value="18">18</option>
				        <option value="19">19</option>
				        <option value="20">20</option> 
				        <option value="21">21</option>
				        <option value="22">22</option>
				        <option value="23">23</option>
				        <option value="24">24</option>
				        <option value="25">25</option>
				        <option value="26">26</option>
				        <option value="27">27</option>
				        <option value="28">28</option>
				        <option value="29">29</option>
				        <option value="30">30</option> 
				        <option value="31">31</option>
				        <option value="32">32</option>
				        <option value="33">33</option>
				        <option value="34">34</option>
				        <option value="35">35</option>
				        <option value="36">36</option>
				        <option value="37">37</option>
				        <option value="38">38</option>
				        <option value="39">39</option>
				        <option value="40">40</option> 
				        <option value="41">41</option>
				        <option value="42">42</option>
				        <option value="43">43</option>
				        <option value="44">44</option>
				        <option value="45">45</option>
				        <option value="46">46</option>
				        <option value="47">47</option>
				        <option value="48">48</option>
				        <option value="49">49</option>
				        <option value="50">50</option> 
				        <option value="51">51</option>
				        <option value="52">52</option>
				        <option value="53">53</option>
				        <option value="54">54</option>
				        <option value="55">55</option>
				        <option value="56">56</option>
				        <option value="57">57</option>
				        <option value="58">58</option>
				        <option value="59">59</option>

				    </select>
				
					<br />
        
        			<label for="eventEnd" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px;">Event End</label>
        
        			<select name="yearEnd" onchange="monthEndDisplay();">
          			
          				<option value="">Select Year</option>
			        	<option value="2016">2016</option>
			        	<option value="2017">2017</option>
			        	<option value="2018">2018</option>
			          	<option value="2019">2019</option>
			          	<option value="2020">2020</option>
			          	<option value="2021">2021</option>
			          	<option value="2022">2022</option>
			          	<option value="2023">2023</option>
			          	<option value="2024">2024</option>
			          	<option value="2025">2025</option>
			          	<option value="2026">2026</option>
        
        			</select>

        			<select name="monthEnd" id="monthEndID" onchange="addDaysEnd(monthEnd.value, yearEnd.value);">
            
            			<option value="">Select Month</option>
			          	<option value="01">January</option>
				        <option value="02">Febraury</option>
				        <option value="03">March</option>
				        <option value="04">April</option>
				        <option value="05">May</option>
				        <option value="06">June</option>
				        <option value="07">July</option>
				        <option value="08">August</option>
				        <option value="09">September</option>
				        <option value="10">October</option>
				        <option value="11">November</option>
				        <option value="12">December</option> 

        			</select>

        			<select id="daysOfMonthEnd" name="dateEnd" onchange="hoursEndDisplay();">

             			<option value="0">Select Date</option>
        
        			</select>

        			<select name="hoursEnd" id="hoursEndID" onchange="minuteEndDisplay();">
          
        				<option value="">Select Hour</option>
			          	<option value="00">12 midnight</option>
				        <option value="01">1 am</option>
				        <option value="02">2 am</option>
				        <option value="03">3 am</option>
				        <option value="04">4 am</option>
				        <option value="05">5 am</option>
				        <option value="06">6 am</option>
				        <option value="07">7 am</option>
				        <option value="08">8 am</option>
				        <option value="09">9 am</option>
				        <option value="10">10 am</option>    
				        <option value="11">11 am</option>  
				        <option value="12">12 noon</option>
				        <option value="13">1 pm</option>
				        <option value="14">2 pm</option>
				        <option value="15">3 pm</option>
				        <option value="16">4 pm</option>
				        <option value="17">5 pm</option>
				        <option value="18">6 pm</option>
				        <option value="19">7 pm</option>
				        <option value="20">8 pm</option>
				        <option value="21">9 pm</option>
				        <option value="22">10 pm</option>    
				        <option value="23">11 pm</option>				

        			</select>

        			<select name="minuteEnd" id="minuteEndID" onchange="/*validateEventDuration(yearStart.value, monthStart.value,dateStart.value, hoursStart.value, minuteStart.value, yearEnd.value, monthEnd.value,dateEnd.value, hoursEnd.value, minuteEnd.value);*/">
          
        				<option value="">Select Minute</option>
				        <option value="00">00</option> 
				        <option value="01">01</option>
				        <option value="02">02</option>
				        <option value="03">03</option>
				        <option value="04">04</option>
				        <option value="05">05</option>
				        <option value="06">06</option>
				        <option value="07">07</option>
				        <option value="08">08</option>
				        <option value="09">09</option>
				        <option value="10">10</option> 
				        <option value="11">11</option>
				        <option value="12">12</option>
				        <option value="13">13</option>
				        <option value="14">14</option>
				        <option value="15">15</option>
				        <option value="16">16</option>
				        <option value="17">17</option>
				        <option value="18">18</option>
				        <option value="19">19</option>
				        <option value="20">20</option> 
				        <option value="21">21</option>
				        <option value="22">22</option>
				        <option value="23">23</option>
				        <option value="24">24</option>
				        <option value="25">25</option>
				        <option value="26">26</option>
				        <option value="27">27</option>
				        <option value="28">28</option>
				        <option value="29">29</option>
				        <option value="30">30</option> 
				        <option value="31">31</option>
				        <option value="32">32</option>
				        <option value="33">33</option>
				        <option value="34">34</option>
				        <option value="35">35</option>
				        <option value="36">36</option>
				        <option value="37">37</option>
				        <option value="38">38</option>
				        <option value="39">39</option>
				        <option value="40">40</option> 
				        <option value="41">41</option>
				        <option value="42">42</option>
				        <option value="43">43</option>
				        <option value="44">44</option>
				        <option value="45">45</option>
				        <option value="46">46</option>
				        <option value="47">47</option>
				        <option value="48">48</option>
				        <option value="49">49</option>
				        <option value="50">50</option> 
				        <option value="51">51</option>
				        <option value="52">52</option>
				        <option value="53">53</option>
				        <option value="54">54</option>
				        <option value="55">55</option>
				        <option value="56">56</option>
				        <option value="57">57</option>
				        <option value="58">58</option>
				        <option value="59">59</option>

       				</select>
        
           			<br />
        
        			<br />
		
					<label for="eventText" style="width: 100%; text-align: left; font-family: 'Oswald', cursive; padding: 10px; ">What is the cause for your event?</label>
					<br />
				
					<textarea name="eventText" style="border-collapse: collapse; padding: 10px; width: 100%; line-height: 1; height: 350px; "></textarea>
					<br />
				
					<br />
        
        			<label for="eventPicture" style="width: 20%; text-align: center; font-family: 'Oswald', cursive; padding: 10px; color: white;">Upload a picture</label>
        			<input type="file" name="eventPicture" />
        			<br />
				
					<br />
				
					<div style="text-align: right;" id="createBtn">
						<input class="btn btn-md btn-info" type="submit" name="submitPetition" value="Create Event" style="padding: 30px;" />
					</div>
			
				</form>
		
			</div>		
	
		</div>

		<script type="text/javascript">
	    
		    function addDaysStart(month, year)
		    {
		      	var arr = [
		                  	[0,31,28,31,30,31,30,31,31,30,31,30,31],
		                  	[0,31,29,31,30,31,30,31,31,30,31,30,31]
		                  ]

		      	if(((year) % 4 == 0) && (((year) % 100 != 0) || ((year) % 400 == 0)))
		        	leap = 1
		      	else
		        	leap = 0

		      	var dateDrop = document.getElementById("daysOfMonthStart")

		      	dateDrop.innerHTML = "<option value=''>Select Date</option>"

		      	for (i = 1; i <= arr[leap][parseInt(month)]; i++)
		      	{
		        	dateDrop.innerHTML += ("<option value='"+i+"'>"+i+"</option>")
		      	}

		      	dateDrop.style.visibility = "visible"
		    }

		    function addDaysEnd(month, year)
		    {
		      	var arr = [
		                  	[0,31,28,31,30,31,30,31,31,30,31,30,31],
		                  	[0,31,29,31,30,31,30,31,31,30,31,30,31]
		                  ]

		      	if(((year) % 4 == 0) && (((year) % 100 != 0) || ((year) % 400 == 0)))
		       		leap = 1
		      	else
		        	leap = 0

		      	var dateDrop = document.getElementById("daysOfMonthEnd")

		      	dateDrop.innerHTML = "<option value=''>Select Date</option>"

		      	for (i = 1; i <= arr[leap][parseInt(month)]; i++)
		      	{
		        	dateDrop.innerHTML += ("<option value='"+i+"'>"+i+"</option>")
		      	}

		      	dateDrop.style.visibility = "visible"
		    }

		    function monthStartDisplay()
		    {
		    	var temp = document.getElementById("monthStartID")
		    	temp.style.visibility = "visible"
		    }

		    function hoursStartDisplay()
		    {
		    	var temp = document.getElementById("hoursStartID")
		    	temp.style.visibility = "visible"
		    }

		    function minuteStartDisplay()
		    {
		    	var temp = document.getElementById("minuteStartID")
		    	temp.style.visibility = "visible"
		    }

		    function monthEndDisplay() 
		    {
		    	var temp = document.getElementById("monthEndID")
		    	temp.style.visibility = "visible"
		    }

		    function hoursEndDisplay()
		    {
		    	var temp = document.getElementById("hoursEndID")
		    	temp.style.visibility = "visible"
		    }

		    function minuteEndDisplay()
		    {
		    	var temp = document.getElementById("minuteEndID")
		    	temp.style.visibility = "visible"
		    }

/*		    function validateEventDuration(yearStart, monthStart, dateStart, hoursStart, minuteStart, yearEnd, monthEnd,dateEnd, hoursEnd, minuteEnd)
		    {
		    	var start = new Date(yearStart, monthStart, dateStart, hoursStart, minuteStart, 0, 0)
		    	var end = new Date(yearEnd, monthEnd, dateEnd, hoursEnd, minuteEnd, 0, 0)

		    	var submit = document.getElementById("createBtn")

		    	if (end.getTime() <= start.getTime())
		    	{
		    		submit.disabled = true
		    	}
		    	else
		    	{
		    		submit.disabled = false
		    	}
		    }
*/
  		</script>

	</body>
  	
</html>