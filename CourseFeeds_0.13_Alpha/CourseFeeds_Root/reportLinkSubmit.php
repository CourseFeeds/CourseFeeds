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
			<div data-role="header" data-theme="c"> 
				<h1>
					<span style="font-size:16pt;font-weight:bold;">
						Link Reported
					</span>
				</h1> 
			</div><!-- header -->
			<?php
			$reportLink = htmlspecialchars($_GET["reportLink"]);//gets the link Id of the reported link
			$violation = $_GET["select-choice-violation"]; //Gets the type of violation
			$reason = $_GET["textarea"]; //gets the details of the reported link submitted by the reported
			$reason = addslashes($reason);
			// Add report to ReportedLinks table
			$query2 = "INSERT INTO ReportedLinks (Reporter, CourseLinkID, ReportedDate, Reason, Description) VALUES ('".$user_data['Name']."', '".$reportLink."', NOW(), '".$violation."', '".$reason."')"; //updates the table with the reported link
			mysql_query($query2);
			// Get link info for email
			$query3 = "SELECT Poster, CourseID, URL, Title, Description, CreatedDate, DownVotes FROM CourseLinks WHERE ID = '".$reportLink."'";
			$result2 = mysql_query($query3);
			$result = mysql_fetch_array($result2);
			$Poster = $result['Poster'];
			$CourseID = $result['CourseID'];
			$URL = $result['URL'];
			$Title = $result['Title'];
			$Description = $result['Description'];
			$CreatedDate = $result['CreatedDate'];
			$DownVotes = $result['DownVotes'];
			echo'
			<div data-role="content">
				<ul data-role="listview" data-theme="c" class="ui-listview">
					</br>
					<li>
						Thanks for helping out!<br />
						We will review the questionable link as soon as possible to determine if it needs to be removed.
					</li>
					<br />
					<a href="linkdetails.php?linkID='.$reportLink.'" data-role="button" data-theme="b" style="margin:10px;">
						Close
					</a>
					';
					//send email to moderators with violation information and confirm removal link
					$from = "no-reply@coursefeeds.com";
					$subject = 'Link Violation: '. $violation .', Violator: '. $Poster;
					//email message
					$message =
					"<div style=\"font-size: 13pt;\">Link Violation ". $violation ."
					<br /><br />
					<br />Report Details: " . stripslashes($reason) . "
					<br />Date/Time Reported: " .date('m-d-Y H:i:s'). "
					<br />Reporter's Username: " .$user_data['Name']. " 
					<br /><br />
					<br />Link Title: " .$Title. "
					<br />CourseID: " .$CourseID. "
					<br />Date Added: " .$CreatedDate. "
					<br />Violater's Username: " .$Poster. "
					<br />Link URL (caution, may contain malware): " .$URL. "
					<br />Link Details: " .$Description. "
					<br />Negative Votes: " .$DownVotes. "
					<br />Link ID: " .$reportLink. "
					<br /><br /> <a href=\"http://www.coursefeeds.com/deleteLink.php?linkID=".$reportLink."\">Delete Link</a><br /></div>";
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
	</body>		
	<?php include 'includes/analytics.php'; ?>
</html>
