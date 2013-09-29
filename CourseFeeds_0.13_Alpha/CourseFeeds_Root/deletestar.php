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
		$deleteLinkID = htmlspecialchars($_GET["linkID"]);
		$query = ("DELETE FROM Favorites WHERE User='".$user_data['Name']."' AND CourseLinkID='".$deleteLinkID."'");
		mysql_query($query);
		header('Location: favorites.php');
		?>
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
