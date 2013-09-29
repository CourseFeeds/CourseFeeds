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
		$linkID		= urldecode($_GET["linkID"]);
		$commentID	= urldecode($_GET["commentID"]);
		echo'
		<div data-role="page" data-theme="c">
			<div data-role="header" data-theme="c"> 
				<h1>
					<span style="font-size:16pt;font-weight:bold;">
						Delete Comment
					</span>
				</h1> 
			</div><!-- header -->
			<div data-role="content" data-theme="b">
				<p>Do you really want to delete this comment from CourseFeeds? <br />It will be gone forever :(</p>
				<div style="float:right;">
					<a href="linkdetails.php?linkID='.$linkID.'" data-role="button" data-mini="true" data-inline="true" data-theme="c">No</a>
					<a href="commentdeleting.php?linkID='.$linkID.'&commentID='.$commentID.'" data-role="button" data-mini="true" data-inline="true" data-theme="b">Yes</a>
				</div>		
			</div><!-- /content -->
		</div><!-- /page -->';
		?>
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
