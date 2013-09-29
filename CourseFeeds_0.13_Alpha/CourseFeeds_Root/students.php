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
			$courseID = htmlspecialchars($_GET["courseID"]); //gets the courseID from the URL
			$courseName = urldecode($_GET["courseName"]); //gets the course name from the URL
			echo '
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>
					<span style="font-size:14pt; color: #21445b;">
						'.$courseName.'
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;"><img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" /></a>
			</div><!-- /header -->';
			?>	
			<div data-role="content">
				<ul data-role="listview" data-filter="true" data-divider-theme="d" data-filter-placeholder="Search for a student..." data-theme="d" class="ui-listview">
					<?php	
					$query 	= "SELECT ec.User, (SELECT CONCAT(u.LastName, ', ', u.FirstName) AS Name FROM User u WHERE u.Name = ec.User) AS Name,
					(SELECT COUNT(*) FROM CourseLinks cl WHERE cl.Poster = ec.User) AS TotalLinks FROM EnrolledCourses ec WHERE ec.CourseID = '".$courseID."'
					AND ec.Archived = 0";
					$sql	= mysql_query($query);
					$lastDivider = '\0';    //The most recent letter used as a divider
					$firstLetter = '\0';     //The first letter of the subject pulled from the DB
					while ($rows = mysql_fetch_assoc($sql)){
						$userName = $rows["User"];
						$name = $rows["Name"];
						$firstLetter = substr($name,0,1);
						if($firstLetter != $lastDivider){
							echo '<li data-role="list-divider" class="ui-li ui-li-divider ui-bar-d">' . $firstLetter . '</li>'; // Get first letter of subject to determine if new section divider needs to be added
							$lastDivider = $firstLetter;
						}
						echo'
						<li>
							<a href="student.php?poster='.$userName.'">
								<span style="float:left;">'.$name.'</span>
								<span style="float:right;">('.$userName.')</span>
								<span class="ui-li-count ui-btn-up-c ui-btn-corner-all">'.$rows["TotalLinks"].'</span>
							</a>
						</li>';
					}	
					?>		    
				</ul>		
			</div><!-- /content -->
			<div data-role="footer" data-position="fixed" class="nav-glyphish-example">
				<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
					<ul>
						<li><a href="indexRefresh.html" id="home-icon" data-icon="custom">Home</a></li>
						<li><a href="browse.php" id="browse-icon" data-icon="custom" class="ui-btn-active">Browse</a></li>
						<li><a href="favorites.php" id="favorites-icon" data-icon="custom">Favorites</a></li>
						<li><a href="addlinkSubject.php" id="addlink-icon" data-icon="custom">Add Link</a></li>
					</ul>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
