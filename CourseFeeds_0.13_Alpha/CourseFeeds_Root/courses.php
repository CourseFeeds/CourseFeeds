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
			$showAll = htmlspecialchars($_GET["showAll"]); // show all courses, regardless of semester
			$MOOC = htmlspecialchars($_GET["MOOC"]); // get MOOC value if Coursera or edX are selected from index.php
			$today = time(); //gets current date string
			$timestamp = $today - 604800; //sets timestamp to 7 days ago
			$newDate = date("Y-m-d H:i:s", $timestamp); //changes timestamp to date string
			$subject = urldecode($_GET["subject"]); //gets subject from URL
			$school = htmlspecialchars($_GET["school"]); //gets campus from URL
			$length	= strlen($subject);
			$start = strlen($subject);
			for($start; $start > 0 && $subject[$start] !='('; $start--); //finds the acronym by looking for a (
			$end = $start; //sets the end to the beginning of the acronym
			for($end; $end > 0 && $subject[$end] !=')'; $end++);//finds the end of the acronym
			$subjectAcronym		= substr($subject, $start+1, $end - $start - 1); //increase start by one to get past the ( and then end-start-1 is how many spots it reads
			//yes this is confusing, but I don't have a better way to get it at the moment
			echo '
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>
					<span style="font-family:Avenir Next;font-size:14pt; color: #21445b;">
						'; if(! empty($MOOC)){echo $MOOC;}else{echo $subject;} echo'
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;"><img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" /></a>
			</div><!-- /header -->';
			?>
			<div data-role="content">
				<div class="content-secondary"  style="margin-top:-16px">
					<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-b ui-corner-none">
							General Links
						</li>
						<?php			
						// Links related to subject(s) selected //
						if($MOOC == "Coursera"){	
							$query = "SELECT sl.ID, sl.MediaType, sl.Title, sl.Description, sl.CreatedDate, sl.TotalViews, c.MOOC, s.IconPath
							  FROM SubjectLinks sl
							  INNER JOIN Subject s ON s.Subject = sl.Subject
							  INNER JOIN Courses c ON c.Subject = sl.Subject
							  WHERE c.MOOC= 'Coursera' ORDER BY sl.TotalViews DESC"; //Pulls the moderator picked links
						}else if($MOOC == "edX"){
							$query = "SELECT sl.ID, sl.MediaType, sl.Title, sl.Description, sl.CreatedDate, sl.TotalViews, c.MOOC, s.IconPath
							  FROM SubjectLinks sl
							  INNER JOIN Subject s ON s.Subject = sl.Subject
							  INNER JOIN Courses c ON c.Subject = sl.Subject
							  WHERE c.MOOC= 'edX' ORDER BY sl.TotalViews DESC"; //Pulls the moderator picked links
						}else{
							$query = "SELECT sl.ID, sl.MediaType, sl.Title, sl.Description, sl.CreatedDate, sl.TotalViews, s.IconPath
							  FROM SubjectLinks sl
							  INNER JOIN Subject s ON s.Subject = sl.Subject
							  WHERE sl.Subject= '".$subject."' ORDER BY sl.UpVotes"; //Pulls the moderator picked links
						};			  
						$result = mysql_query($query); //runs the query
						while($row = mysql_fetch_array($result)){ //takes one row at a time from the query
							$ID				= $row["ID"];
							$title 			= $row["Title"];
							$mediaType 		= $row["MediaType"];
							$description	= $row["Description"];
							$views			= $row["TotalViews"];
							$poster			= $row["Poster"];
							$icon			= $row["IconPath"];
						echo'
						<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li li-fix ui-btn-up-c">
							<img src="'.$icon.'_Full.png" alt="Subject Icon" class="thumbnail-fix"/>
							<div class="ui-li">
								<div class="ui-btn-text">
									<a href="subjectlinkdetails.php?linkID='.$ID.'" class="ui-link-inherit">				
										<h3 class="ui-li-heading">
											'.$title.'
										</h3>
										<p class="ui-li-desc"> 
											'.$mediaType.' - '.$views.' Views 
										</p>
										<p class="ui-li-desc"> 
											'.$description.' 
										</p>
										<div class="ui-icon icon-fix ui-icon-arrow-r ui-icon-shadow"></div>	
									</a>
								</div>
							</div>	
						</li>'; //outputs the information about the link 
						}
						?>
					</ul>	
				</div>		
				<div class="content-primary">
					<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" data-dividertheme="b" data-filter="true" data-filter-placeholder="Search for courses..." class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
						<?php
						if(empty($showAll)){
							if(! empty($MOOC)){
								$query = "SELECT c.Title, c.ID, c.CourseNumber, c.Subject
										  FROM Courses c
										  WHERE c.MOOC='".$MOOC."'
										  ORDER BY c.Subject, c.CourseNumber";//For MOOCs, This orders the results by the first letter of the subject of the class
							}else{
								$query = "
								SELECT c.Title, c.ID, c.CourseNumber, c.Subject, cs.CourseID, cs.Semester, se.Semester, se.StartDate, se.EndDate 
										  FROM Courses c
										  INNER JOIN CourseSemesters cs ON cs.CourseID = c.ID
										  INNER JOIN Semester se ON se.Semester = cs.Semester 
										  WHERE c.Subject= '".$subject."' AND c.School='".$school."' AND se.EndDate > CURDATE() 
										  ORDER BY c.CourseNumber";//This orders the results by the first number of the coursenumber of the class
							}
						}else{
							if(! empty($MOOC)){
								$query = "SELECT c.Title, c.ID, c.CourseNumber, c.Subject 
										  FROM Courses c
										  WHERE c.MOOC='".$MOOC."'
										  ORDER BY c.Subject, c.CourseNumber";//For MOOCs, This orders the results by the first letter of the subject of the class
							}else{
								$query = "
								SELECT c.Title, c.ID, c.CourseNumber, c.Subject
										  FROM Courses c
										  WHERE c.Subject= '".$subject."' AND c.School='".$school."'
										  ORDER BY c.CourseNumber";//This orders the results by the first number of the coursenumber of the class
							}
						}
						$result = mysql_query($query);
						if(! empty($MOOC)){
							while($row = mysql_fetch_array($result)){
								$courseName		= $row["Title"];
								$courseID 		= $row["ID"];
								$courseNumber	= $row["CourseNumber"];
								$courseSubject	= $row["Subject"];
								if($courseSubject != $lastSubject){
									echo '
									<li data-role="list-divider">
										'.$courseSubject.'
									</li>'; // Get first letter of subject to determine if new section divider needs to be added
									$lastSubject = $courseSubject;
								}
								echo
								'<li>
									<a href="course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($lastSubject).'&subjectAcronym='.urlencode($subjectAcronym).'&courseNumber='.urlencode($courseNumber).'">
										'.$subjectAcronym.' '.$courseNumber.' - '.$courseName.'
									</a>
								</li>';
							}
						}else{ 
							$intro = 0;
							while($row = mysql_fetch_array($result)){
								$courseName		= $row["Title"];
								$courseID 		= $row["ID"];
								$courseNumber	= $row["CourseNumber"];
								$firstLetter = substr($courseNumber,0,1);//creates a substring of the first number and inserts a header to seperate the class levels based on course number
								if($courseNumber < 100){
									if($intro == 0){
										echo '
										<li data-role="list-divider">
											Introductory Level
										</li>'; // Get first letter of subject to determine if new section divider needs to be added
										$intro = 1;
									}
								}else if($firstLetter != $lastDivider){
									echo '<li data-role="list-divider">'.substr($courseNumber,0,1). '00 Level</li>'; // Get first letter of subject to determine if new section divider needs to be added
									$lastDivider = substr($courseNumber,0,1);
								}
								echo
								'<li>
									<a href="course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($courseSubject).'&subjectAcronym='.urlencode($subjectAcronym).'&courseNumber='.urlencode($courseNumber).'">
										'.$subjectAcronym.' '.$courseNumber.' - '.$courseName.'
									</a>
								</li>';
							}
						}
						if(empty($showAll) && empty($MOOC)){ echo'
						<li data-theme="g" data-icon="refresh">
								<a href="courses.php?subject='.urlencode($subject).'&school='.urlencode($school).'&showAll=1">
									Show Courses from All Semesters
								</a>
						</li>
						';
						}else{
						if(! empty($showAll) && empty($MOOC)){ echo'
						<li data-theme="r" data-icon="refresh">
								<a href="courses.php?subject='.urlencode($subject).'&school='.urlencode($school).'">
									Hide Courses from Other Semesters
								</a>
						</li>
						';
						}	
						}	
						?>
					</ul>			
				</div>	
			</div><!-- /content -->	
			<?php
			echo'
			<div data-role="footer" data-position="fixed" class="nav-glyphish-example">
				<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
					<ul>
						<li><a href="indexRefresh.html" id="home-icon" data-icon="custom">Home</a></li>
						<li><a href="browse.php?campus='.$school.'" id="browse-icon" data-icon="custom" class="ui-btn-active">Browse</a></li>
						<li><a href="favorites.php" id="favorites-icon" data-icon="custom">Favorites</a></li>
						<li><a href="addlinkSubject.php?campus='.$school.'" id="addlink-icon" data-icon="custom">Add Link</a></li>
					</ul>
				</div>
			</div><!-- /footer -->';
			?>
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
