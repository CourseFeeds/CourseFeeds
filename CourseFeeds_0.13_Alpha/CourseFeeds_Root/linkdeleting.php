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
		$linkID	= htmlspecialchars($_GET["linkID"]);		
		$query2 = "SELECT Poster FROM CourseLinks WHERE ID='".$linkID."'";//gets the details about the link
		$result = mysql_query($query2);
		$poster = $result['Poster'];		
		if($user_data['Name'] == $poster OR $user_data['IsModerator'] == '1'){
			$query = ("DELETE FROM CourseLinks WHERE ID=".$linkID."");
			mysql_query($query);
			header('Location: index.php');
		}else{ 
			echo'Sorry, you must be the submitter of the link or a moderator to delete this link. You may be getting this error if you are not signed in.';
		};
		?>
		<?php include 'includes/analytics.php'; ?>		
	</body>
</html>
