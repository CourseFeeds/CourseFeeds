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
		$deleteLinkID = htmlspecialchars($_GET["linkID"])
		?>
		<div data-role="page" data-theme="b">
			<div data-role="header" data-theme="c"> 
				<h1>
					<span style="font-size:16pt;font-weight:bold;">
						Remove Link
					</span>
				</h1> 
			</div><!-- header -->
			<?php
			echo'
			<div data-role="content" data-theme="b">
				<p>
					Do you really want to remove this link from the Starred list?
				</p>
				<div style="float:right;">
					<a href="favorites.php" data-role="button" data-mini="true" data-inline="true" data-theme="c">
						No
					</a>
					<a href="deletestar.php?linkID='.$deleteLinkID.'" data-role="button" data-mini="true" data-inline="true" data-theme="b">
						Yes
					</a>
				</div>
			</div><!-- /content -->';
			?>
		</div><!-- /page -->';
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
