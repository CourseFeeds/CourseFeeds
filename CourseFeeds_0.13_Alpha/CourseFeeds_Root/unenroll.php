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
			$go = urldecode($_GET["go"]);
			$courseName = urldecode($_GET["courseName"]); //gets the course name from the URL
			$courseID = urldecode($_GET["courseID"]); //gets the course ID from the URL
			$subject = urldecode($_GET["subject"]); //gets the subject from the URL
			$query = ("DELETE FROM EnrolledCourses WHERE CourseID=".$courseID." AND User ='".$user_data['Name']."'");
			if($go ==""){
				echo'
				<div data-role="page" data-theme="c">		
					<div data-role="header" data-theme="c"> 		
						<h1>
							<span style="font-size:12pt;font-weight:bold;">
								Remove from My Courses
							</span>
						</h1> 	
					</div><!-- header -->		
					<div data-role="content" data-theme="b">		
						<p>
							Do you really want to remove this course from My Courses? <br />
						</p>
						<div style="float:right;">
							<a href="course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($subject).'" data-role="button" data-mini="true" data-inline="true" data-theme="c">
								No
							</a>
							<a href="unenroll.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($subject).'&go=yes" data-role="button" data-mini="true" data-inline="true" data-theme="b">
								Yes
							</a>
						</div>		
					</div><!-- /content -->
				</div><!-- /page -->';
			}else{
				$query = ("DELETE FROM EnrolledCourses WHERE CourseID=".$courseID." AND User ='".$user_data['Name']."'");
				mysql_query($query);
				header('Location: index.php');
			}
			?>			
			<?php include 'includes/analytics.php'; ?>		
	</body>
</html>
