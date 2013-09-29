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
		$linkID = htmlspecialchars($_GET["linkID"]);
		echo'
		<div data-role="page" data-theme="c">
			<div data-role="header" data-theme="c"> 
				<h1>
					<span style="font-size:16pt;font-weight:bold;">
						Delete Link
					</span>
				</h1> 
			</div> <!-- header -->
			<div data-role="content" data-theme="b">
				<p>Do you really want to delete this link from CourseFeeds? <br />It will be gone forever :(</p>
				<div style="float:right;">
					<a href="linkdetails.php?linkID='.$linkID.'" data-role="button" data-mini="true" data-inline="true" data-theme="c">No</a>
					<a href="linkdeleting.php?linkID='.$linkID.'" data-role="button" data-mini="true" data-inline="true" data-theme="b">Yes</a>
				</div>		
			</div><!-- /content -->
		</div><!-- /page -->'
		?>	
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
