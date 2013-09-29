<?php
include 'core/init.php';
$version = "0.13 Alpha";
?>
<!DOCTYPE html> 
<html>
	<head> 
		<?php include 'includes/head.php'; ?>		
	</head>  
	<body>  
		<?php
		if (logged_in() === true){
			$courseName = urldecode($_GET["courseName"]); //gets the course name from the URL
			$courseID	= htmlspecialchars($_GET["courseID"]); //gets the course ID from the URL
			$subjectAcronym = urldecode($_GET["subjectAcronym"]);
			$courseNumber	= urldecode($_GET["courseNumber"]);
			// Post submit page starts here if this is true
			if (!empty($_POST)){
				// Grab the value of the course they want to overwrite (-1 for an empty spot)
				$cID = $_POST["radio-choice"];
				$query;
				if ($cID == -1){ // Insert 
					$query = "INSERT INTO EnrolledCourses (User, CourseID, Archived)
					VALUES (
					'".$user_data['Name']."',
					".$courseID.",
					0)";
				}else{ // Update
					$query = "UPDATE EnrolledCourses SET CourseID = '".$courseID."' WHERE CourseID = '".$cID."' AND User = '".$user_data['Name']."' ";
				}
				$result = mysql_query($query);
				if ($result){ // Successful query		
					// echo a successful query with link back to course page
					echo '
					<div data-role="dialog" id="success">
					<div data-role="header" data-theme="c">
					<h1><span style="font-size:16pt;font-weight:bold;">Enrolled</span></h1> 
					</div>	
					<div data-role="content">
					<p>You have successfully enrolled in '.$courseName.'! <br />A new shortcut has been added to the Home page.</p>
					<a href="course.php?courseName='.$courseName.'&courseID='.$courseID.'&subject=('.$subjectAcronym.')" data-role="button">
					Continue to '.$courseName.'</a>						
					</div> <!--Content-->
					</div> <!--dialog-->';
				}else{	// Query failed
					// Show the user there was an error
					echo '
					<div data-role="dialog" id="error">
						<div data-role="header" data-theme="c">
							<h1>
								<span style="font-size:16pt;font-weight:bold;">
									Error
								</span>
							</h1> 
					</div>			
					<div data-role="content">
						<p>Sorry, there was an error. Please click the back button and select a storage location for the new course enrollment.</p>									
					</div> <!--Content-->				
				</div> <!--dialog-->';
				}	
		} 		
		// Normal Page Begins
		echo'
		<!--Normal page starts here-->
		<div data-role="page">
			<div data-role="header" data-theme="c" data-id="foo1" data-position="fixed">		
				<h1>
					Add to My Courses<
				/h1>
			</div><!-- /header -->
			<div data-role="content">	
				<!------- Select Storage Location for Enrollment ------->			
				<form action="enroll.php?courseID='.urlencode($courseID).'&courseName='.$courseName.'&subjectAcronym='.urlencode($subjectAcronym).'&courseNumber='.urlencode($courseNumber).'" method="post">		
					<ul data-role="listview" data-prevent-focus-zoom="true" data-inset="false" data-theme="c">
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-c">
							Adding '.$subjectAcronym.' '.$courseNumber.' - '.$courseName.'
						</li>
						<fieldset data-role="controlgroup">
						<legend></legend>';
						$count = 0;		
						// Fetch all currently enrolled courses.
						$query = "SELECT ec.CourseID, c.Title 
						FROM EnrolledCourses ec 
						INNER JOIN Courses c ON ec.CourseID = c.ID 
						WHERE ec.User = '".$user_data['Name']."' 
						AND ec.Archived != 1
						LIMIT 0, 10";
						$results = mysql_query($query);		
						// Loop through the results
						while($row = mysql_fetch_array($results)){	
							// Create radio buttons and labels for each currently enrolled course. The value of the radio button is the courseID
							echo'
							<li data-inset="false" class="ui-li">	
								<input type="radio" name="radio-choice" id="radio-choice-'.$count.'" value="'.$row["CourseID"].'" />			
								<label for="radio-choice-'.$count.'">'.$row["Title"].'</label>
							</li>';	
							// Increment count
							$count++;
						} 
						// Fill in with empty slots (up to 10 total)
						// Each empty slot has a value of -1 so we know that it is empty in POST
						if($count < 10){
							echo'
							<li data-inset="false" class="ui-li">	
							<input type="radio" name="radio-choice" id="radio-choice-'.$count.'" value="-1" checked="checked" />			
							<label for="radio-choice-'.$count.'" style="background:#CCFFCC;">Empty Spot</label>
							</li>';
							echo'<li><div style="margin:10px;font-weight:bold;font-size:10pt;">Select the Empty Spot or overwrite an existing spot.</div></li>';
						}else{ 
									echo'
										<li>
											<div style="margin:10px;font-weight:bold;font-size:10pt;color:red;">
												Sorry, you have reached the maximum limit of My Courses storage (10 spots), please overwrite an existing course or close this pop-up.
											</div>
										</li>';};
									echo'    	
										</fieldset>
										<li data-inset="false" data-role="fieldcontain" class="ui-field-contain ui-body ui-br">
											<div style="text-align:center;">
												<label for="enroll"></label>
												<input id="enroll" type="submit" value="Submit" data-mini="false" data-theme="b" data-icon="check" data-inline="false" />
											</div>
										</li>
									</ul>
								</form> <!-- /form -->
							</div><!-- /content -->';	
						}else{ // User is not logged in
							echo'
							<div data-role="page" style="background-image:url(images/special/diagTrees.jpg);background-size: cover;background-repeat:no-repeat;">
								<div data-role="content">
									<div data-role="header" data-theme="c" data-id="foo1" data-position="fixed">
										<h1>Add to My Courses</h1>
									</div><!-- /header -->
								<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="c" class="ui-listview ui-listview-inset ui-corner-all ui-shadow" style="margin: 10% 0% 10% 0%;opacity:0.75;">
									<li style="opacity:1.0;">
										<div style="text-align:center;font-size:24pt;padding:10px;">Please Sign In to Access this Feature</div>
										<div class="ui-grid-a"><div class="ui-block-a"><a href="register.php" data-role="button" data-mini="true" data-rel="dialog" data-transition="pop" data-theme="c" data-icon="plus" data-rel="dialog" data-transition="flip" style="padding:0;">Register</a></div>
										<div class="ui-block-b"><a href="loginForm.php" data-role="button" data-mini="true" data-rel="dialog" data-transition="flip" data-icon="check" data-theme="b" style="padding:0;">Sign In</a></div></div>
									</li>
								</ul>
					';};
					?>		
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
