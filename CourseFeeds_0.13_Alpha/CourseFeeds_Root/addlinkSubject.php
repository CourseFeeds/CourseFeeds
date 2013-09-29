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
		if (logged_in() === true) {
		echo ' 
		<div data-role="page">
			<div data-role="panel" id="mypanel" class="ui-responsive" data-theme="d" data-position="right" data-display="overlay" data-dismissible="true">
				<ul data-role="listview" data-theme="d" data-divider-theme="d" class="nav-search">
					<li id="menuSmall-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
						<a href="#" data-rel="close">
							<span style="margin-left:22px;">
								Close Menu
							</span>
						</a>
					</li>
					<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">Account Options</li>';
					$campus = $user_data['Campus'];	
					echo'
					<li>User: '.$user_data['Name'].'</li>
					<li class="active ui-btn-icon-left" id="logout-icon" data-icon="custom" data-icon-pos="left">
						<a href="logout.php">
							<span style="margin-left:22px;">
								Sign Out
							</span>
						</a>
					</li>
					<li id="settings-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
						<a href="settings.php" data-rel="dialog" data-transition="pop">
							<span style="margin-left:22px;">
								Settings
							</span>
						</a>
					</li>';
		?>		
					<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">General Information</li>
					<li id="about-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="about.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">About</span></a></li>
					<li id="campusReq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="requestCampus.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Request Campus</span></a></li>
					<li id="faq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="techSupport.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Technical Support</span></a></li>
					<li id="modApp-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="modApp.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Moderator Application</span></a></li>
					<li id="bugReport-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="reportBug.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Report Bug</span></a></li>
					<li id="legal-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="legal.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Legal</span></a></li>		
					<?php
					if (logged_in() === true) { 
						echo'<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">My Courses</li>';
						///////////////////////// My Courses //////////////////////////	
						$query	= mysql_query("SELECT c.ID, c.Title as CourseTitle, c.Subject, s.IconPath, c.CourseNumber  
						FROM EnrolledCourses ec 
						INNER JOIN Courses c ON ec.CourseID = c.ID
						INNER JOIN Subject s ON c.Subject = s.Subject
						WHERE ec.User ='".$user_data['Name']."' AND ec.Archived = '0'");	
						while($data	= mysql_fetch_array($query)){
							$subject = $data["Subject"];
							//// my confusing code to get us the acronym ////
							$length	=	strlen($subject);
							$start	= 	strlen($subject);
							for($start; $start > 0 && $subject[$start] !='('; $start--); //finds the acronym by looking for a (
							$end = $start; //sets the end to the beginning of the acronym
							for($end; $end > 0 && $subject[$end] !=')'; $end++);//finds the end of the acronym
							$subjectAcronym	= substr($subject, $start+1, $end - $start - 1); //increase start by one to get past the ( and then end-start-1 is how many spots it reads
							echo'
							<li>
								<a href="course.php?courseID='.$data["ID"].'&courseName='.urlencode($data["CourseTitle"]).'&subject='.urlencode($data["Subject"]).'" class="ui-link-inherit">											
									'. $data["CourseTitle"] .'								
								</a>	
							</li>';
						}	
					}
						/////////////////////////
					?>	
				</ul>		
			</div><!-- /panel -->	
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>
					<span style="font-size:14pt; color: #21445b;">
						Add Link
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;"><img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" /></a>
			</div><!-- /header -->
			<?php	
			$campus = htmlspecialchars($_GET["campus"]); // define variable campus
			if(empty($campus)){
				$campus = $user_data['Campus'];
			};		
			echo '
			<div data-role="content">	
				<ul data-role="listview" data-theme="c" class="ui-listview" style="padding-bottom:15px;">
					<li data-role="list-divider" class="ui-li ui-li-divider ui-bar-d">My Courses</li>';	
					$query = "SELECT c.Title, c.Subject, c.ID, c.CourseNumber
							FROM EnrolledCourses ec 
							INNER JOIN Courses c ON ec.CourseID = c.ID 
							WHERE ec.User = '".$user_data['Name']."' AND ec.Archived = 0";	
					$results = mysql_query($query);
					while($row = mysql_fetch_array($results)){
						//// my confusing code to get us the acronym ////
						$subject = $row["Subject"];
						$length	=	strlen($subject );
						$start	= 	strlen($subject );
						for($start; $start > 0 && $subject[$start] !='('; $start--); //finds the acronym by looking for a (
						$end = $start; //sets the end to the beginning of the acronym
						for($end; $end > 0 && $subject[$end] !=')'; $end++);//finds the end of the acronym
						$subjectAcronym	= substr($subject, $start+1, $end - $start - 1); //increase start by one to get past the ( and then end-start-1 is how many spots it reads
						$title = $row["Title"];
						echo'
						<li>
							<a href="addlink.php?subject='.urlencode($row["Subject"]).'&course='.urlencode($title).'&id='.$row[ID].'&campus='.$campus.'">
								'.$subjectAcronym	.' '.$row["CourseNumber"].' - '.$title.'
							</a>
						</li> ';
					};
					echo '	
					</ul>'; // The above empty content is used to seperate the top section from the drop down menu
					
					//////////////    Dropdown Menu Begins    //////////////	
					echo'	
					<ul data-role="listview" data-filter="false" data-theme="c" class="ui-listview">	
						<li>
							<form action="addlinkSubject.php?campus='.$campus.'" method="post">
								<div data-role="fieldcontain" class="ui-field-contain ui-body ui-br ui-hide-label">
									<label for="select-choice-min" class="select"></label>
									<select onchange="window.location=\'addlinkSubject.php?campus=\' + this.value;" name="select-choice-min" id="select-choice-min" data-native-menu="true" data-mini="true" tabindex="-1">';
										echo'
										<optgroup label="Select a Campus">
											<option value="'.$campus.'">'.$campus.'</option>'; //sets the placeholder for the school the user is currently browsing in
											$results = mysql_query("SELECT Name FROM Schools WHERE Name != '".$campus."' ORDER BY Name"); //gets all schools the user isn't currently browsing
											while($schools = mysql_fetch_array($results)){
												echo'<option value="'.$schools["Name"].'">'.$schools["Name"].'</option>'; 
											};// populates the drop down with all schools
										echo'
										</optgroup>				
									</select>
								</div>						
							</form>
						</li>
					</ul>
					<!-- Used to correct formatting issue with search filter box position -->
					<ul data-role="listview" style="height:36px;">
					<li style="height:0px;">&nbsp;</li> 
					</ul>';
					//////////////    Dropdown Menu Ends    //////////////
					echo '
					<ul data-role="listview" data-filter="true" data-filter-placeholder="Search for a subject..." data-theme="d" class="ui-listview">';		
						/* Populate subjects based on campus */	
						$sql = mysql_query("SELECT DISTINCT Subject FROM Courses WHERE School ='".$campus."' ORDER BY Subject");	
						$subject_name = 'Subject';
						$lastDivider = '\0';    //The most recent letter used as a divider
						$firstLetter = '\0';     //The first letter of the subject pulled from the DB
						while ($rows = mysql_fetch_assoc($sql)){
							$firstLetter = substr($rows[$subject_name],0,1);
							if ($firstLetter != $lastDivider){
								echo '<li data-role="list-divider" class="ui-li ui-li-divider ui-bar-d">' . substr($rows[$subject_name],0,1) . '</li>'; // Get first letter of subject to determine if new section divider needs to be added
								$lastDivider = substr($rows['Subject'],0,1);
							}
							echo '<li><a href="addlink.php?subject='.urlencode($rows['Subject']).'&campus='.$campus.'"> '.$rows['Subject'].'</a></li>';
						};	
					?>
					</ul>
				</div><!-- /content -->				
			<?php	
			}else{echo '
			<div data-role="page" style="background-image:url(\'images/special/backgrounds/active_backgrounds/addlinkBackground.jpg\');background-size:cover; background-repeat:no-repeat !important;">
				<div data-role="panel" id="mypanel" class="ui-responsive" data-theme="d" data-position="right" data-display="overlay" data-dismissible="true">
					<ul data-role="listview" data-theme="d" data-divider-theme="d" class="nav-search">
						<li id="menuSmall-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
							<a href="#" data-rel="close">
								<span style="margin-left:22px;">
									Close Menu
								</span>
							</a>
						</li>				
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">Account Options</li>				
						<li class="active ui-btn-icon-left" id="login-icon" data-icon="custom" data-icon-pos="left">
							<a href="loginForm.php" data-rel="dialog" data-transition="pop">
								<span style="margin-left:22px;">
									Sign In
								</span>
							</a>
						</li>			
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">General Information</li>
						<li id="about-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="about.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">About</span></a></li>
						<li id="campusReq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="requestCampus.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Request Campus</span></a></li>
						<li id="faq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="techSupport.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Technical Support</span></a></li>
						<li id="modApp-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="modApp.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Moderator Application</span></a></li>
						<li id="bugReport-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="reportBug.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Report Bug</span></a></li>
						<li id="legal-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="legal.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Legal</span></a></li>			
					</ul>
				</div><!-- /panel -->	
				<div data-role="header" data-theme="c" data-position="fixed">		
					<h1>
						<span style="font-family:Avenir Next;font-size:14pt; color: #21445b;">
							Add Link
						</span>
					</h1>			
					<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;">
						<img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" />
					</a>
				</div><!-- /header -->		
				<!-- Note: Content tags removed to fix background repeat bug caused by slide-out panel -->
				<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="c" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin: 10% 3% 10% 3%;opacity:0.75;">
					<li style="opacity:1.0;">
						<div style="text-align:center;font-size:24pt;padding:10px;">Please Sign In to Access this Feature</div>
						<div class="ui-grid-a">
							<div class="ui-block-a">
								<a href="register.php" data-role="button" data-mini="true" data-rel="dialog" data-transition="pop" data-theme="c" data-icon="plus" style="padding:0;">
									Register
								</a>
							</div>
							<div class="ui-block-b">
								<a href="loginForm.php" data-role="button" data-mini="true" data-rel="dialog" data-transition="pop" data-icon="custom" id="signInBlue-icon" data-theme="b" style="padding:0;">
									Sign In
								</a>
							</div>
						</div>
					</li>
				</ul>	
			';};
			?>		
			<div data-role="footer" data-position="fixed" class="nav-glyphish-example">
				<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
					<ul>
						<li><a href="indexRefresh.html" id="home-icon" data-icon="custom">Home</a></li>
						<li><a href="browse.php" id="browse-icon" data-icon="custom">Browse</a></li>
						<li><a href="favorites.php" id="favorites-icon" data-icon="custom">Favorites</a></li>
						<li><a href="addlinkSubject.php" id="addlink-icon" data-icon="custom" class="ui-btn-active">Add Link</a></li>
					</ul>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
