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
		$linkID		= htmlspecialchars($_GET["linkID"]);
		$commentID	= htmlspecialchars($_GET["commentID"]);
		$query			= ("DELETE FROM Comments WHERE ID=".$commentID."");
		mysql_query($query);
		header('Location: linkdetails.php?linkID='.$linkID.'');
		?>
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
