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
		<div data-role="dialog" data-transition="none">
			<div data-role="header" data-theme="c" data-theme="b"> 
				<h1>
					<span style="font-size:16pt;font-weight:bold;">
						Comment Reported
					</span>
				</h1> 
			</div><!-- header -->
			<?php
			$reportCommentID = htmlspecialchars($_GET["reportCommentID"]);//gets the link Id of the reported link
			$linkID = htmlspecialchars($_GET["linkID"]);//gets the link Id of the reported link
			$violation	= $_GET["select-choice-violation"]; //Gets the type of violation
			$reason	= $_GET["textarea"]; //gets the details of the reported comment submitted by the reported
			$reason = addslashes($reason);
			// Add report to ReportedLinks table
			$query2 = "INSERT INTO ReportedComments (Reporter, CommentID, ReportedDate, Reason, Description, CourseLinkID) VALUES ('".$user_data['Name']."', '".$reportCommentID."', NOW(), '".$violation."', '".$reason."', '".$linkID."')"; //updates the table with the reported comment
			mysql_query($query2);
			// Get link info for email
			$query3 = "SELECT Poster, CourseLinkID, Comment, CreatedDate FROM Comments WHERE ID='".$reportCommentID."'";
			$result2 = mysql_query($query3);
			$result = mysql_fetch_array($result2);
			$Poster = $result['Poster'];
			$CourseID = $result['CourseLinkID'];
			$Comment = $result['Comment'];
			$CreatedDate = $result['CreatedDate'];
			echo'
			<div data-role="content">
				<ul data-role="listview" data-theme="c" class="ui-listview">
					</br>
					<li>
						Thanks for helping out!<br />We will review the questionable 
						comment as soon as possible to determine if it needs to be removed.
					</li>
					<br />
					<a href="linkdetails.php?linkID='.$linkID.'" data-role="button" data-theme="b" style="margin:10px;">
						Close
					</a>
					';
					//send email to moderators with violation information and confirm removal link
					$from = "no-reply@coursefeeds.com";
					$subject = 'Comment Violation: '. $violation .', Violator: '. $Poster;
					//email message
					$message =
					"<div style=\"font-size: 13pt;\">Link Violation ". $violation ."
					<br /><br />
					<br />Report Details: " . stripslashes($reason) . "
					<br />Report Submission Date/Time: " .date('m-d-Y H:i:s'). "
					<br />Reporter's Username: " .$user_data['Name']. " 
					<br /><br />
					<br />Comment: " .$Comment. "
					<br />CourseID: " .$CourseID. "
					<br />Comment Submission Date/Time: " .$CreatedDate. "
					<br />Violater's Username: " .$Poster. "
					<br /><br /> <a href=\"http://www.coursefeeds.com/linkdetails.php?linkID=".$linkID."\">View Link</a><br />
					<br /><br /> <a href=\"http://www.coursefeeds.com/deleteComment.php?linkID=".$linkID."&commentID=".$reportCommentID."\">Delete Comment</a><br /></div>";
					$to  = 'cwoolf@coursefeeds.com';
					// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:' . $from . "\r\n";
					mail( $to, $subject,
					$message, $headers);
					?>
				</ul>
			</div><!-- /content -->	
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
