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
		<div data-role="page" data-theme="b">
			<div data-role="header" data-theme="c"> 	
				<h1>
					<span style="font-size:16pt;font-weight:bold;">
						Starred Link
					</span>
				</h1> 	
			</div><!-- header -->
			<div data-role="content" data-theme="b">
			<?php
			$linkID = htmlspecialchars($_GET["linkID"]); // get the link the user wants to favorite
			$query = "INSERT INTO Favorites (ID, User, CourseLinkID) VALUES (NULL, '".$user_data['Name']."', ".$linkID.")";
			$result = mysql_query($query);
			if($result){
				echo '
				<p>The link was successfully added to your Starred Links.</p>
				<div style="float:right;">
					<a href="linkdetails.php?linkID='.$linkID.'" data-role="button" data-mini="true" data-inline="true" data-theme="c">
						Back to Link
					</a>				
					<a href="favorites.php" data-role="button" data-mini="true" data-inline="true" data-theme="b">
						OK, show me where it is saved!
					</a>
				</div>';
			}else{
				echo '
				<p>Sorry, there was an error!</p>';
			}
				?>
			</div><!-- /content -->
		</div><!-- /page -->	
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
