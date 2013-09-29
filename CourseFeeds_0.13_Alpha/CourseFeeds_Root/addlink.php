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
		if (logged_in() === true) 
		{
			// Assign variables	  
			$subject = urldecode($_GET["subject"]);  // Get the subject 
			$campus = htmlspecialchars($_GET["campus"]); // Get the campus
			$course = urldecode($_GET["course"]);  // Get the course name
			$courseID = htmlspecialchars($_GET["id"]);	// Get the course id
		
			// code to get the acronym
			$length	=	strlen($subject);
			$start	= 	strlen($subject);
			// finds the acronym by looking for a (
			for($start; $start > 0 && $subject[$start] !='('; $start--){
				// sets the end to the beginning of the acronym
				$end = $start;
			}
			// finds the end of the acronym
			for($end; $end > 0 && $subject[$end] !=')'; $end++){
				// increase start by one to get past the ( and then end-start-1 is how many spots it reads
				$subjectAcronym		= substr($subject, $start+1, $end - $start - 1);
			}
			// Post submit page starts here if this is true
			// Check for any post action
			if (!empty($_POST)){
				$required_fields = array('title','url');
				foreach($_POST as $key=>$value){
					// Check for empty required fields
					if(empty($value) && in_array($key, $required_fields)){
						$errors[] = 'Fields marked with an asterisk are required';
						break 1;
					}
				}
			$url = $_POST["url"];
			// Use a regular expression to validate the URL. code from http://codekarate.com/blog/validating-url-php
			if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)){
				$errors[] .= " The URL you supplied is not valid. Please enter a different one. 
		   		If you typed the URL please make sure to include a fully qualified prefix like http://www.";
			}
			$courseID = $_POST["Courses"];
			// Run a query to check if the link already exists for this course.
			$checkQuery = mysql_query("SELECT CASE WHEN EXISTS (
										SELECT cl.ID
										FROM CourseLinks cl
										WHERE cl.CourseID = ".$courseID."
										AND cl.URL =  '".$url."')
										THEN 1
										ELSE 0
						  				END");
			$count = mysql_result($checkQuery, 0);
			if ($count == 1){
				$errors[] .= "The URL you supplied has already been linked to this course. Please post a different link.";
			}
			// Input requirements passed
			if (empty($errors)){
				// Insert the values the user defined into course links
				$query = 
				"INSERT INTO CourseLinks (Subject, Poster, MediaType, CourseID, URL, Title, Description, CreatedDate) 
				VALUES (
				'".$subject."', 
				'".$user_data['Name']."', 
				'".$_POST["MediaTypes"]."', 
				".$courseID.", 
				'".$url."', 
				'".sanitize($_POST["title"])."', 
				'".sanitize($_POST["description"])."', 
				NOW());";
				$results = mysql_query($query);
				// If the query ran successfully
				if ($results){
					// Grab the link ID
					$linkID = mysql_insert_id();
					// Add this link to the user's favorites list
					$addFavQuery = "INSERT INTO Favorites (User, CourseLinkID) VALUES('".$user_data["Name"]."', ".$linkID.")";
					// Execute the insert
					mysql_query($addFavQuery);
					$postTags = $_POST["tags"];
					if (!empty($postTags)){
						// Add the tags to the link
						$addTagsQuery = "INSERT INTO CourseLinkTags (CourseLinkID, Poster, Tag, DateTagged) VALUES ";
						// Split the tags by spaces					
						$tags = explode(" ", sanitize($postTags));
						$needInsert = false;
						$needComma = false;
						// Loop through each of the tags
						for($i = 0; $i < count($tags); $i++){
							// Get the tag, check if it is valid (ie does not contain spaces) then add it to the query
							$tag = $tags[$i];
							if (strlen($tag) <= 30){
								$needInsert = true;
								// Check to see if we are inserting more than one tag
								if ($needComma){
									$addTagsQuery .= ",";
								}
								// Concatenate another insert string to the query
								$addTagsQuery .= "(".$linkID.", '".$user_data["Name"]."', '".$tag."', NOW())";
								// Now we need a comma for any more tags
								$needComma = true;
							}
					}		
					if ($needInsert){
						// Execute the insert
						mysql_query($addTagsQuery);
					}
				}
				// echo a successful query with links back to useful pages
				echo '
				<div data-role="dialog" id="success">
					<div data-role="header" data-theme="c">
						<h1><span style="font-size:16pt;font-weight:bold;">Successful Post</span></h1> 
					</div>	
					<div data-role="content">
						<p>You have successfully added your link and it has been added to your favorites list for you!</p>
						<a href="addlinkSubject.php?campus='.$campus.'" data-role="button">
							Choose Another Course</a>
						<a href="linkdetails.php?linkID='.$linkID.'" data-role="button" >View My Link</a>
						<a href="favorites.php" data-role="button" >View My Favorites</a>
					</div> <!--Content-->
				</div> <!--dialog-->';
				}else{	// Query failed
				// Show the user there was an error
					echo '
					<div data-role="dialog" id="error">
					<div data-role="header" data-theme="c">
					<h1><span style="font-size:16pt;font-weight:bold;">Error</span></h1> 
					</div>			
					<div data-role="content">
					<p>Sorry, there was an error.</p>
					<a href="addlink.php?subject='.urlencode($subject).'&campus='.$campus.'" 
					data-role="button" data-transition="flip">Try Again</a>							
					</div> <!--Content-->				
					</div> <!--dialog-->';
				}	
			}else{ // Missing/Incorrect input
				echo '	
				<div data-role="dialog" id="error">
					<div data-role="header" data-theme="c">
						<h1><span style="font-size:16pt;font-weight:bold;">Add Link</span></h1> 
					</div>			
					<div data-role="content">';
						echo output_errors($errors); 
					echo '</div> <!--Content-->
				</div> <!--dialog-->';
				exit(); // Prevents the rest of the page from loading
			}
		};
		echo ' 
		<div data-role="page" data-add-back-btn="true">
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
				<li id="settings-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="settings.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Settings</span></a></li>
				<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">General Information</li>
				<li id="about-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="about.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">About</span></a></li>
				<li id="campusReq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="requestCampus.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Request Campus</span></a></li>
				<li id="faq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="techSupport.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Technical Support</span></a></li>
				<li id="modApp-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="modApp.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Moderator Application</span></a></li>
				<li id="bugReport-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="reportBug.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Report Bug</span></a></li>
				<li id="legal-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="legal.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Legal</span></a></li>
				<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">My Courses</li>';
				///////////////////////// My Courses /////////////////////////
				
				$query				= mysql_query("SELECT c.ID, c.Title as CourseTitle, c.Subject, s.IconPath, c.CourseNumber  
								   FROM EnrolledCourses ec 
								   INNER JOIN Courses c ON ec.CourseID = c.ID
								   INNER JOIN Subject s ON c.Subject = s.Subject
								   WHERE ec.User ='".$user_data['Name']."' AND ec.Archived = '0'");
				
				while($data			= mysql_fetch_array($query))
				{
				$subject1 = $data["Subject"];
				//// my confusing code to get us the acronym ////
				$length	=	strlen($subject1);
				$start	= 	strlen($subject1);
				for($start; $start > 0 && $subject1[$start] !='('; $start--); //finds the acronym by looking for a (
				$end = $start; //sets the end to the beginning of the acronym
				for($end; $end > 0 && $subject1[$end] !=')'; $end++);//finds the end of the acronym
				$subjectAcronym1 = substr($subject1, $start+1, $end - $start - 1); //increase start by one to get past the ( and then end-start-1 is how many spots it reads
				
				echo'
				<li>
					<a href="course.php?courseID='.$data["ID"].'&courseName='.urlencode($data["CourseTitle"]).'&subject='.urlencode($data["Subject"]).'" class="ui-link-inherit">											
							'. $data["CourseTitle"] .'								
					</a>	
				</li>
				';
			}				
			$campus2 = htmlspecialchars($_GET["campus"]);			
			echo'	</ul>
			</div><!-- /panel -->	
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>
					<span style="font-size:14pt; color: #21445b;">
						Add Link
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;"><img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" /></a>
			</div><!-- /header -->
			<div data-role="content">
				<form action="addlink.php?subject='.urlencode($subject).'&campus='.$campus2.'" method="post">
					<ul data-role="listview" data-prevent-focus-zoom="true" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-corner-none">
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-b ui-corner-none">
							Course Information
						</li>
						<li>
							Subject: &nbsp;&nbsp;';
							echo $subject; 
							echo'
						</li>
						<li data-role="fieldcontain" class="ui-field-contain ui-body ui-br">
							<label for="Courses" class="select ui-select">Course: </label>
							<div class="ui-select">
								<select name="Courses" id="Courses" data-native-menu="false" data-theme="c" tabindex="-1">';
								$query = "";
								// Check to see if the course has been set or not.
								if (! empty($course)){					
									// Run a query to fetch course details
									$query = "SELECT c.ID, c.Title, c.CourseNumber
											FROM Courses c 
											WHERE c.ID = '".$courseID."'";
								}else{ 
									// Run a query to fetch all courses
									$query = "SELECT c.ID, c.Title, c.CourseNumber
											FROM Courses c 
											WHERE c.School = '".$campus2."' AND c.Subject = '".$subject."' 
											ORDER BY c.CourseNumber";
								}							
								$results = mysql_query($query);							
								while($row = mysql_fetch_array($results)){
									echo '<option value="'.$row["ID"].'">'.$subjectAcronym.' '.$row["CourseNumber"].' - '.$row["Title"].'</option>';
								}
					?>					
								</select>
							</div>
						</li>
					</ul>
					<!--Link Info-->
					<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-corner-none">
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-b ui-corner-none">
							Link Information
						</li>				
						<li data-role="fieldcontain">
							<label for="title">Title:* &nbsp;&nbsp;</label>
							<input type="text" maxlength="100" name="title" id="title"  placeholder="Up to 100 characters"/>
						</li>		
						<li data-role="fieldcontain">
							<label for="url">URL (Copy/Paste):* &nbsp;&nbsp;</label>
							<input type="text" maxlength="2000" name="url" id="url" placeholder="Up to 2000 characters"/>           
						</li>
						<li data-role="fieldcontain">
							<label for="tags">Tags:&nbsp;&nbsp;</label>
							<input type="text" maxlength="217" name="tags" id="tags" placeholder="Enter tags seperated by spaces." />
						</li>
						<li data-role="fieldcontain">
							<label for="description" >Description:</label>
							<textarea name="description" id="description" maxlength="1500" class="ui-input-text ui-body-c ui-corner-none ui-shadow-inset" style="height:200px;" 
							placeholder="Up to 1500 characters"></textarea>   
						</li>
						<li data-role="fieldcontain" class="ui-field-contain ui-body ui-br">
							<label for="MediaTypes">Media Type: &nbsp;&nbsp;</label>
							<div class="ui-select">
								<select name="MediaTypes" id="MediaTypes" data-native-menu="false" tabindex="-1">
						<?php	
								// Fetch all media types ordered by their type (ie Web Content, File...)
								$query = "SELECT m.MediaType, m.Description, m.Type FROM MediaTypes m ORDER BY m.Type";
								$results = mysql_query($query);
								$lastType = "";
								$firstRun = true;
								while($row = mysql_fetch_array($results)){
									$type = $row["Type"];				
									if ($lastType != $type){
										if (!$firstRun){
											echo '</optgroup>';
										}else{
											$firstRun = false;
										}
										$lastType = $type;
										echo '<optgroup label="'.$type.'">';
									}		
										echo '<option value="'.$row["MediaType"].'">'.$row["Description"].'</option>';
								}
						?>
								</select>
						</li>		
						<li data-role="fieldcontain" class="ui-field-contain ui-body ui-br">
							<label for="addLink"></label>
							<input id="addLink" type="submit" value="Add Link" data-theme="b" data-mini="true" data-inline="true" />
						</li>
					</ul>
				</ul>
			</form> <!-- /form -->
		</div><!-- /content -->	
		<?php	
		}else{
			echo '
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
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>Add Link</h1>			
				<a href="#mypanel" class="ui-btn-right" id="menu-icon" data-icon="custom">Menu</a>
			</div><!-- /header -->
			<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="c" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin: 10% 3% 10% 3%;opacity:0.75;">
				<li style="opacity:1.0;">
					<div style="text-align:center;font-size:24pt;padding:10px;">Please Sign In to Access this Feature</div>
					<div class="ui-grid-a"><div class="ui-block-a"><a href="register.php" data-role="button" data-mini="true" data-theme="c" data-icon="plus" data-rel="dialog" data-transition="pop" style="padding:0;">Register</a></div>
					<div class="ui-block-b"><a href="loginForm.php" data-role="button" data-mini="true" data-rel="dialog" data-transition="pop" data-icon="custom" id="signIn-icon" data-theme="b" style="padding:0;">Sign In</a></div></div>
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
