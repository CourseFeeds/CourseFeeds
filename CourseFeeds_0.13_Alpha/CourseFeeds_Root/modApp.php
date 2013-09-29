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
					<span style="font-size:12pt;font-weight:bold;">
						Moderator Application
					</span>
				</h1> 
			</div><!-- header -->
			<div data-role="content" data-theme="b">
				<span style="font-size:10pt;">
					CourseFeeds moderation functionality is currently incomplete. 
					Feel free to contribute via GitHub if you find the time!
				</span>
				<br /><br />
				<a href="https://github.com/CourseFeeds/cfeeds" target="_blank" data-role="button" data-mini="true" 
				data-rel="dialog" data-transition="pop" data-icon="custom" id="fork-icon" data-theme="c" style="padding:0;">
					GitHub
				</a>
			</div><!-- content-->
		</div><!-- /page -->
	</body>
	<?php include 'includes/analytics.php'; ?>
</html>
