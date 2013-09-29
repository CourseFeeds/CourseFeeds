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
		<div data-role="page" data-add-back-btn="true">
			<div data-role="panel" id="mypanel" class="ui-responsive" data-theme="d" data-position="right" data-display="overlay" data-dismissible="true">
				<?php include 'includes/panelCompact.php'; ?>				
			</div><!-- /panel -->
			<?php
			$today = time(); //gets current date string
			$timestamp = $today - 604800; //sets timestamp to 7 days ago
			$newDate = date("Y-m-d H:i:s", $timestamp); //changes timestamp to date string
			$error;
			$courseName = urldecode($_GET["courseName"]); //gets the course name from the URL
			$courseID	= htmlspecialchars($_GET["courseID"]); //gets the course ID from the URL
			$subject5	= urldecode($_GET["subject"]); //gets the subject from the URL
			$currentVote= htmlspecialchars($_GET["currentVote"]);
			$voteLinkID = htmlspecialchars($_GET["voteLinkID"]);
			$length5	=	strlen($subject5);
			$start5	= 	strlen($subject5);
			for($start5; $start5 > 0 && $subject5[$start5] !='('; $start5--){ //finds the acronym by looking for a (
				$end5 = $start5; //sets the end to the beginning of the acronym
			}
			for($end5; $end5 > 0 && $subject5[$end5] !=')'; $end5++){ //finds the end of the acronym
				$subjectAcronym5 = substr($subject5, $start5+1, $end5 - $start5 - 1); //increase start by one to get past the ( and then end-start-1 is how many spots it reads
			}
			// get course name
			$query5 = "SELECT CourseNumber FROM Courses WHERE Title = '".$courseName."'";
			$results5 = mysql_query($query5);
			$courseNumberArray = mysql_fetch_assoc($results5);//gets the course number
			$courseNumber = $courseNumberArray["CourseNumber"];
			// get school name
			$query6 = "SELECT School FROM Courses WHERE ID = '".$courseID."'";
			$results6 = mysql_query($query6);
			$schoolNameArray = mysql_fetch_assoc($results6);//gets the course number
			$schoolName = $schoolNameArray["School"];		
			//This is here to check for variables indicating that the user has voted and what their vote was if they did
			if($voteLinkID==''){
				$error = true;
			}else if($currentVote==''){
				$error = true;
			}else{
				$error = false;
			}
			if($error == false){ //This only runs if the user has voted on a link
				$results 		= mysql_query("SELECT Count(*) as count FROM UserCourseLinkVotes WHERE CourseLinkID = '".$voteLinkID."' AND Voter='".$user_data['Name']."'");
				$row 			= mysql_fetch_assoc($results);//checks to see if the user has voted
				$positive 		= mysql_query("SELECT UpVote FROM UserCourseLinkVotes WHERE CourseLinkID = '".$voteLinkID."' AND Voter='".$user_data['Name']."'");
				$positiveVote	= mysql_fetch_array($positive);//Checks if the users vote was a positive vote or a negative vote.
				if($row["count"] == 0){
					$haveVoted	= false;
				}else{ 
					$haveVoted = true;
				}
				if($haveVoted == true && $currentVote == 1){ //checks if the user has voted and wants to vote down
					if($positiveVote["UpVote"] == 0){ //sees if the user voted down
						mysql_query("UPDATE CourseLinks SET UpVotes = UpVotes + 1 , DownVotes = DownVotes - 1, LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'"); //removes a downvote and adds an upvote
						mysql_query("UPDATE UserCourseLinkVotes SET UpVote= 1 WHERE CourseLinkID = '".$voteLinkID."'");
						header('Location: course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($subject5).'&courseNumber='.urlencode($courseNumber).''); //instantly reloads the page so the correct votes will appear
					}else{
						mysql_query("UPDATE CourseLinks SET UpVotes = UpVotes - 1, LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'"); //cancels out the users previous vote (upvote in this case)
						mysql_query("DELETE FROM UserCourseLinkVotes WHERE Voter= '".$user_data['Name']."' AND CourseLinkID= '".$voteLinkID."'"); //deletes the fact that the user has voted
						header('Location: course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($subject5).'&courseNumber='.urlencode($courseNumber).'');
					}
				}
				if($haveVoted == true && $currentVote == 0){//if they have voted and their current vote is a downvote
					if($positiveVote["UpVote"] == 1){ //sees if the user voted up previously on the link
						mysql_query("UPDATE CourseLinks SET UpVotes = UpVotes - 1, DownVotes = DownVotes + 1, LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'"); //removes an upvote and adds an downvote to the link
						mysql_query("UPDATE UserCourseLinkVotes SET UpVote= 0 WHERE CourseLinkID = '".$voteLinkID."'");
						header('Location: course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($subject5).'&courseNumber='.urlencode($courseNumber).'');
					}else{ //the user voted down on a previous link
						mysql_query("UPDATE CourseLinks SET DownVotes = DownVotes - 1, LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'"); //cancels out the users previous vote (downvote in this case)
						mysql_query("DELETE FROM UserCourseLinkVotes WHERE Voter= '".$user_data['Name']."' AND  CourseLinkID= '".$voteLinkID."'"); //deletes the fact that the user has voted
						header('Location: course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($subject5).'&courseNumber='.urlencode($courseNumber).''); //refreshes the page
					}
				}
				if($haveVoted == false && $currentVote == 0){ //The user has not voted previously on the link and would like to vote down
					mysql_query("UPDATE CourseLinks SET DownVotes = DownVotes + 1, LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'"); //adds a downvote to the current link
					mysql_query("INSERT INTO UserCourseLinkVotes (Voter, CourseLinkID, UpVote) VALUES ('".$user_data['Name']."', '".$voteLinkID."', '0')"); //inserts that the user has now voted
					header('Location: course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($subject5).'&courseNumber='.urlencode($courseNumber).'');
				}
				if($haveVoted == false && $currentVote == 1){ //The use has not voted on the link and would like to vote up
					mysql_query("UPDATE CourseLinks SET UpVotes = UpVotes + 1, LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'"); //adds an upvote to the current link
					mysql_query("INSERT INTO UserCourseLinkVotes (Voter, CourseLinkID, UpVote) VALUES ('".$user_data['Name']."', '".$voteLinkID."', '1')"); //inserts that the user has now voted			
					header('Location: course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($subject5).'&courseNumber='.urlencode($courseNumber).'');
				}
			}
			echo '
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>
					<span style="color: #21445b;">
						'.$subjectAcronym.' '.$courseNumber.' - '.$courseName.'
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;"><img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" /></a>
			</div><!-- /header -->';
			?>	
			<div data-role="content">
				<div class="content-secondary" style="margin-top:-16px">
					<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="height:130px;margin-bottom:30px;">
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-top">
							Course Options
						</li> 
						<li style="padding-bottom:20px;">
							<?php
								$query = "SELECT Count(*) as count FROM EnrolledCourses WHERE CourseID= '" .$courseID."' && User='".$user_data['Name']."'";
								$resultSet = mysql_query($query);
								$rows	= mysql_fetch_assoc($resultSet);		
								if($rows["count"] == 0){
									echo'<div style="position:relative;float:left;margin:0;width:50%;margin-right:0;padding-right:0;">
											<a href="enroll.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subjectAcronym='.urlencode($subjectAcronym).'&courseNumber='.urlencode($courseNumber["CourseNumber"]).'"data-role="button"  data-inline="true" data-rel="dialog" data-icon="check" data-mini="true" data-transition="pop" class="ui-link-inherit" style="margin-left:0px;margin-right:-30px;width:100%;padding-bottom:1px;padding-top:1px;">
												My Courses
											</a>
										</div>';
								}else{
									echo'
										<div style="position:relative;float:left;margin:0;width:50%;margin-right:0;padding-right:0;">
											<a href="unenroll.php?courseID='.urlencode($courseID).'&courseName='.urlencode($courseName).'&subject='.urlencode($subject).'" data-role="button" data-inline="true" data-mini="true" data-rel="dialog" data-mini="true" data-transition="pop" data-icon="delete" class="ui-link-inherit" style="margin-left:0px;margin-right:-30px;width:100%;padding-bottom:1px;padding-top:1px;">
												My Courses
											</a>
										</div>';
								}
								$query 	= "SELECT Count(*) as count FROM EnrolledCourses WHERE CourseID= '" .$courseID."'"; //counts the students enrolled in the course
								$results = mysql_query($query); //runs the query above
								$number = mysql_fetch_assoc($results);  //gets the number of students enrolled
									echo'
									<div style="position:relative;float:right;width:50%;margin-right:-24px;margin-left:0;padding-left:0;">									
										<a href="students.php?courseID='. $courseID .'&courseName='.$courseName.'" data-role="button" data-inline="true" data-mini="true" class="ui-li-has-count" style="width:100%;margin-right:-30px;">
											<div class="ui-li-count ui-btn-up-c ui-btn-corner-none" style="position:relative;float:left;margin:-2px 6px 0px 4px;">
												'.$number["count"].'
											</div>
											<div style="margin-right:38px;">
												Students
											</div>
										</a>	
									</div>						
								<div style="clear:both;height:30px;padding-top:5px;">
									<a href="addlink.php?subject='. urlencode($subject5) .'&course='. urlencode($courseName) .'&campus='. urlencode($schoolName) .'&id='. urlencode($courseID) .'" data-role="button" data-theme="b" id="addlinkSmall-icon" data-mini="true" data-icon="custom" style="padding:0;margin-right:-30px;">
										<span style="color:white;">
											Add Link
										</span>
									</a>
								</div>
						</li>
						';?>
							<!-- Semester archives, not fully functional -->
							<!--
							<li>
							<div data-role="collapsible">
							<h3> Semesters Offered </h3>
							<ul style="margin-bottom:30px;">
							<?php  
							$query = "SELECT Semester FROM CourseSemesters WHERE CourseID = '".$courseID."'"; //gets all the semesters the course has been offered
							$result = mysql_query($query);
							while($row = mysql_fetch_array($result))
							{
							$semester	 = $row["Semester"];
							$previousID	 = $row["CourseLinkID"];
							echo '<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-c" style="height:40px;margin-top:5px;">
							<a href="course.php?semester='.$semester.'&courseID='. $courseID .'&courseName='. $courseName .'" class="ui-link-inherit">
							<div style="margin-top:10px; margin-left:10px;">'.$semester.'</div>
							<div class="ui-icon ui-icon-arrow-r ui-icon-shadow" style="position:relative; float: right;margin-top:-15px;"></div></a></li>';
							} 
							?> 
							</ul>
							</div>
							</li>
							-->
					</ul>
					<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin-top:-5px;">
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-top">
							Sorted by Rating
						</li>
						<?php
						$query = "SELECT cl.ID as CourseLinkID, cl.Poster, cl.MediaType, cl.Title, cl.UpVotes, cl.DownVotes, cl.TotalViews,
						(SELECT GROUP_CONCAT(clt.Tag SEPARATOR ', ') FROM  CourseLinkTags AS clt WHERE  clt.CourseLinkID =  cl.ID) AS Tags  
						FROM CourseLinks cl
						WHERE cl.CourseID = \"". $courseID ."\" 
						ORDER BY cl.UpVotes DESC";
						$notLoggedIn	= "You must be logged in to vote on a link.";
						$result			= mysql_query($query);
						while($row = mysql_fetch_array($result)){
							$counting= mysql_query("SELECT Count(*) as count, UpVote FROM UserCourseLinkVotes WHERE CourseLinkID = '".$row["CourseLinkID"]."' AND Voter='".$user_data['Name']."'");
							$positiveVote	= mysql_fetch_assoc($counting);//gets the upvote if the user has voted
							/* Check to see if poster is a professor or moderator, display icons if so */
							$nameIs2 = $row["Poster"];	
							$queryIs2 		= "SELECT IsModerator, IsProfessor FROM User WHERE Name = \"".$nameIs2."\" ORDER BY Name";		
							$resultIs2 		= mysql_query($queryIs2);
							while($rowIs2 = mysql_fetch_array($resultIs2)){
								$IsMod2 = $rowIs2["IsModerator"];
								$IsProf2 = $rowIs2["IsProfessor"];
							}	
							/* Vote number positioning function, determines margins */
							$intUpVotes = strlen($row["UpVotes"]);
							$intDownVotes = strlen($row["DownVotes"]);
							if($intUpVotes == 1){
								$marginUpVote = "5";
							}else if($intUpVotes == 2){
								$marginUpVote = "0";
							}else if($intUpVotes == 3){
								$marginUpVote = "-6";
							}else if($intUpVotes == 4){
								$marginUpVote = "-10";
							}else{
								$marginUpVote = "-10";
								$row["UpVotes"] = "&Chi;&rarr;&infin;";
							};
							if($intDownVotes == 1){
								$marginDownVote = "5";
							}else if($intDownVotes == 2){
								$marginDownVote = "0";
							}else if($intDownVotes == 3){
								$marginDownVote = "-6";
							}else if($intDownVotes == 4){
								$marginUpVote = "-10";
							}else{
								$marginDownVote = "-10";
								$row["DownVotes"] = "&Chi;&rarr;&infin;";
							};		
						echo'			
						<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li li-fix ui-btn-up-c">
							<!-- New Vote Buttons -->
							<div data-role="controlgroup" style="margin-top: -5px;">';
								if (logged_in() === true){ //displays for logged in users so they can vote on links
									if($positiveVote["UpVote"] == 1){ //if the user has a voted positively on a link
										echo'
									<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=1&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="gv" data-icon="check" style="width:90px; height: 50px;">
										<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
											<div style="margin-left:'.$marginUpVote.'px;">
												'.$row["UpVotes"].'
											</div>
										</span>
									</a>
									<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=0&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="r" data-icon="minus" style="width:90px; height: 50px;">
										<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
											<div style="margin-left:'.$marginDownVote.'px;">
												'.$row["DownVotes"].'
											</div>
										</span>
									</a>';
									}else if($positiveVote["UpVote"] == 0 && $positiveVote["count"] != 0){ //if the user has voted negatively on a link
										echo'
										<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=1&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="g" data-icon="plus" style="width:90px; height: 50px;">
											<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
												<div style="margin-left:'.$marginUpVote.'px;">
													'.$row["UpVotes"].'
												</div>
											</span>
										</a>
										<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=0&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="rv" data-icon="check" style="width:90px; height: 50px;">
											<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
												<div style="margin-left:'.$marginDownVote.'px;">
													'.$row["DownVotes"].'
												</div>
											</span>
										</a>';
									}else{ //if the user has not voted on the link yet
										echo'
										<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=1&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="g" data-icon="plus" style="width:90px; height: 50px;">
											<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
												<div style="margin-left:'.$marginUpVote.'px;">
													'.$row["UpVotes"].'
												</div>
											</span>
										</a>
										<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=0&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="r" data-icon="minus" style="width:90px; height: 50px;">
											<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
												<div style="margin-left:'.$marginDownVote.'px;">
													'.$row["DownVotes"].'
												</div>
											</span>
										</a>';
									}
								}else{ //does not allow a click action if the user is not logged in
									echo'
									<a href="#" data-role="button" data-theme="g" data-icon="plus" style="width:90px; height: 50px;">
										<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
											<div style="margin-left:'.$marginUpVote.'px;">
												'.$row["UpVotes"].'
											</div>
										</span>
									</a>
									<a href="#" data-role="button" data-theme="r" data-icon="minus" style="width:90px; height: 50px;">
										<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
											<div style="margin-left:'.$marginDownVote.'px;">
												'.$row["DownVotes"].'
											</div>
										</span>
									</a>';
								}
									echo'			
									</div>
									<div class="ui-li" style="margin-top:-105px;margin-left:100px;">
										<div class="ui-btn-text">
											<a href="linkdetails.php?linkID='.$row["CourseLinkID"].'" class="ui-link-inherit">	<!-- pass required variables to link details page in URL -->			
												<h3 class="ui-li-heading">
													'.stripslashes($row["Title"]).'
												</h3>
												<p class="ui-li-desc">
													'.$row["MediaType"].' - <b>'.$row["TotalViews"].' </b>Views
												</p>
												<p class="ui-li-desc">';
													echo $row["Poster"];
													if(! empty($IsProf2)){
														echo'&nbsp;&nbsp;
															<img src="images/special/IsProfessor.png" style="width: 14px; height: 15px; vertical-align: bottom;" />';
													}
													if(! empty($IsMod2)){
														echo'&nbsp;&nbsp;
														<img src="images/special/IsModerator.png" style="width: 14px; height: 15px; vertical-align: bottom;" />';
													}
												echo'</p>
												<p class="ui-li-desc"> 
													'.$row["Tags"].' 
												</p>
												<div class="ui-icon icon-fix ui-icon-arrow-r ui-icon-shadow">
												</div>	<!-- right arrow icon, dont remove or alter -->
											</a>
										</div>
									</div>	
						</li>';
						}
						?>	
					</ul>	
				</div>
				<div class="content-primary">
					<ul data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="Search for keywords..." data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-top">
							Sorted by Date
						</li>
						<?php
						$query = "SELECT cl.ID as CourseLinkID, cl.Poster, cl.MediaType, cl.Title, cl.UpVotes, cl.DownVotes, cl.TotalViews,
						(SELECT GROUP_CONCAT(clt.Tag SEPARATOR ', ') FROM  CourseLinkTags AS clt WHERE  clt.CourseLinkID =  cl.ID) AS Tags  
						FROM CourseLinks cl
						WHERE cl.CourseID = \"". $courseID ."\" 
						ORDER BY cl.CreatedDate";
						$result			= mysql_query($query);
						while($row = mysql_fetch_array($result)){
							$counting= mysql_query("SELECT Count(*) as count, UpVote FROM UserCourseLinkVotes WHERE CourseLinkID = '".$row["CourseLinkID"]."' AND Voter='".$user_data['Name']."'");
							$positiveVote	= mysql_fetch_assoc($counting);
							/* Check to see if poster is a professor or moderator, display icons if so */
							$nameIs = $row["Poster"];	
							$queryIs 		= "SELECT IsModerator, IsProfessor FROM User WHERE Name = \"".$nameIs."\" ORDER BY Name";		
							$resultIs 		= mysql_query($queryIs);
							while($rowIs = mysql_fetch_array($resultIs)){
								$IsMod = $rowIs["IsModerator"];
								$IsProf = $rowIs["IsProfessor"];
							}	
							/* Vote number positioning function, determines margins */
							$intUpVotes = strlen($row["UpVotes"]);
							$intDownVotes = strlen($row["DownVotes"]);
							if($intUpVotes == 1){
								$marginUpVote = "5";
							}else if($intUpVotes == 2){
								$marginUpVote = "0";
							}else if($intUpVotes == 3){
								$marginUpVote = "-6";
							}else if($intUpVotes == 4){
								$marginUpVote = "-10";
							}else{
								$marginUpVote = "-10";
								$row["UpVotes"] = "&Chi;&rarr;&infin;";
							};
							if($intDownVotes == 1){
								$marginDownVote = "5";
							}else if($intDownVotes == 2){
								$marginDownVote = "0";
							}else if($intDownVotes == 3){
								$marginDownVote = "-6";
							}else if($intDownVotes == 4){
								$marginUpVote = "-10";
							}else{
								$marginDownVote = "-10";
								$row["DownVotes"] = "&Chi;&rarr;&infin;";
							};
							echo'			
							<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li li-fix ui-btn-up-c">
								<!-- New Vote Buttons -->
								<div data-role="controlgroup" style="margin-top: -5px;">';
								if (logged_in() === true){//displays for logged in users so they can vote on links
									if($positiveVote["UpVote"] == 1){//if the user has a voted positively on a link
										echo'
										<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=1&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="gv" data-icon="check" style="width:90px; height: 50px;">
											<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
												<div style="margin-left:'.$marginUpVote.'px;">
													'.$row["UpVotes"].'
												</div>
											</span>
										</a>
										<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=0&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="r" data-icon="minus" style="width:90px; height: 50px;">
											<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
												<div style="margin-left:'.$marginDownVote.'px;">
													'.$row["DownVotes"].'
												</div>
											</span>
										</a>';
									}
								else if($positiveVote["UpVote"] == 0 && $positiveVote["count"] != 0){ //if the user has voted negatively on a link
									echo'
									<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=1&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="g" data-icon="plus" style="width:90px; height: 50px;">
										<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
											<div style="margin-left:'.$marginUpVote.'px;">
												'.$row["UpVotes"].'
											</div>
										</span>
									</a>
									<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=0&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="rv" data-icon="check" style="width:90px; height: 50px;">
										<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
											<div style="margin-left:'.$marginDownVote.'px;">
												'.$row["DownVotes"].'
											</div>
										</span>
									</a>';
									}else{ //if the user has not voted on the link yet
										echo'
										<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=1&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="g" data-icon="plus" style="width:90px; height: 50px;">
											<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
												<div style="margin-left:'.$marginUpVote.'px;">
													'.$row["UpVotes"].'
												</div>
											</span>
										</a>
										<a href="#" onclick="window.location=\'course.php?courseID='.$courseID.'&courseName='.$courseName.'&subject='.urlencode($subject).'&currentVote=0&voteLinkID='.$row["CourseLinkID"].'&courseNumber='.urlencode($courseNumber).'\';" data-role="button" data-theme="r" data-icon="minus" style="width:90px; height: 50px;">
											<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
												<div style="margin-left:'.$marginDownVote.'px;">
													'.$row["DownVotes"].'
												</div>
											</span>
										</a>';
									}
						}else{ //does not allow a click action if the user is not logged in
							echo'
							<a href="#" data-role="button" data-theme="g" data-icon="plus" style="width:90px; height: 50px;">
								<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
									<div style="margin-left:'.$marginUpVote.'px;">
										'.$row["UpVotes"].'
									</div>
								</span>
							</a>
							<a href="#" data-role="button" data-theme="r" data-icon="minus" style="width:90px; height: 50px;">
								<span style="color:white; font-size:18pt;padding:0;white-space:normal;">
									<div style="margin-left:'.$marginDownVote.'px;">
										'.$row["DownVotes"].'
									</div>
								</span>
							</a>';
						}
						echo'			
						</div>
						<div class="ui-li" style="margin-top:-105px;margin-left:100px;">
							<div class="ui-btn-text">
								<a href="linkdetails.php?linkID='.$row["CourseLinkID"].'" class="ui-link-inherit">	<!-- pass required variables to link details page in URL -->			
									<h3 class="ui-li-heading">
										'.stripslashes($row["Title"]).'
									</h3>
									<p class="ui-li-desc">
										'.$row["MediaType"].' - <b>'.$row["TotalViews"].' </b>Views
									</p>
									<p class="ui-li-desc">';
										echo $row["Poster"];
										if(! empty($IsProf2)){
											echo'&nbsp;&nbsp;
											<img src="images/special/IsProfessor.png" style="width: 14px; height: 15px; vertical-align: bottom;" />';
										}
										if(! empty($IsMod2)){
											echo'&nbsp;&nbsp;
											<img src="images/special/IsModerator.png" style="width: 14px; height: 15px; vertical-align: bottom;" />';
										}
									echo'
									</p>
									<p class="ui-li-desc">
										'.$row["Tags"].'
									</p>
									<div class="ui-icon icon-fix ui-icon-arrow-r ui-icon-shadow"></div>	<!-- right arrow icon, dont remove or alter -->
								</a>
							</div>
						</div>	
					</li>';
					}
					?>
				</ul>		
			</div>	
		</div><!-- /content -->			
		<?php
		$query			= "SELECT School FROM Courses WHERE ID = ".$courseID."";
		$result			= mysql_query($query);
		$row 			= mysql_fetch_array($result);
		echo'		
		<div data-role="footer" data-position="fixed" class="nav-glyphish-example">
			<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
				<ul>
					<li><a href="indexRefresh.html" id="home-icon" data-icon="custom">Home</a></li>
					<li><a href="browse.php?campus='.$row["School"].'" id="browse-icon" data-icon="custom" class="ui-btn-active">Browse</a></li>
					<li><a href="favorites.php" id="favorites-icon" data-icon="custom">Favorites</a></li>
					<li><a href="addlinkSubject.php" id="addlink-icon" data-icon="custom">Add Link</a></li>
				</ul>
			</div>
		</div><!-- /footer -->';
		?>		
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>		
	</body>
</html>
