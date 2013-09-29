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
		$linkID		= urldecode($_GET["submit"]);
		$comment	= urldecode($_GET["textarea"]);
		addslashes($comment);
		echo $comment;
		$query = "INSERT INTO Comments (Poster, CourseLinkID, Comment, CreatedDate) VALUES ('".$user_data['Name']."', ".$linkID.", '".$comment."', NOW())";
		$result = mysql_query($query);
		header('Location: linkdetails.php?linkID='.$linkID.'');
		?>
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
