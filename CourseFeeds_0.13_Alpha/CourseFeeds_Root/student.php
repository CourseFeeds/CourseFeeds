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
		<div data-role="page" data-add-back-btn="true">
			<div data-role="panel" id="mypanel" class="ui-responsive" data-theme="d" data-position="right" data-display="overlay" data-dismissible="true">
				<?php include 'includes/panelCompact.php'; ?>				
			</div><!-- /panel -->
			<?php
			$today = time(); //gets current date string
			$timestamp = $today - 604800; //sets timestamp to 7 days ago
			$newDate = date("Y-m-d H:i:s", $timestamp); //changes timestamp to date string
			$poster = htmlspecialchars($_GET["poster"]); //gets the user that posted the links from URL
			echo '<div data-role="header" data-theme="c" data-position="fixed">		
			<h1><span style="font-size:14pt; color: #21445b;">'. $poster .'</span></h1>			
			<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;"><img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" /></a>
			</div><!-- /header -->
			<div data-role="content">
			<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
				<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">
					All Links Submitted by '.$poster.'
				</li>';
				$query  = "SELECT  s.IconPath, cl.ID, cl.UpVotes, cl.DownVotes, cl.Title, cl.MediaType, cl.TotalViews, 
				   (SELECT GROUP_CONCAT(clt.Tag SEPARATOR ', ') FROM  CourseLinkTags AS clt WHERE  clt.CourseLinkID =  cl.ID) AS Tags 
				   FROM CourseLinks AS cl
				   INNER JOIN Courses AS c ON c.ID = cl.CourseID
				   INNER JOIN Subject AS s ON s.Subject = c.Subject
				   WHERE cl.Poster = '".$poster."' 
				   ORDER BY cl.UpVotes DESC"; //gets course links posted by the specified user
				$result = mysql_query($query); //runs the query
				while($row = mysql_fetch_array($result)){ //takes one row at a time from the query
					$iconPath		= $row["IconPath"];
					$linkID			= $row["ID"];
					$upVotes		= $row["UpVotes"];
					$downVotes		= $row["DownVotes"];
					$title 			= $row["Title"];
					$mediaType 		= $row["MediaType"];
					$views			= $row["TotalViews"];
					$tags			= $row["Tags"]; 
					echo'
						<li style="height:120px;">
							<div style="float:left;">
								<img src="'.$iconPath.'.png" alt="Subject Icon" width="90px" height="90px" class="thumbnail-fix" style="width:90px !important;height:90px !important;" />'; 
								if($tags){ // Special fomatting needed when the link has tags
									echo '
									<div class="greenbubble">
										'.$upVotes.'
									</div>
									<div class="redbubble">
										'.$downVotes.'
									</div>'; 
								}else{
									echo '
									<div class="greenbubble" style="margin-bottom:-15px;">
										'.$upVotes.'
									</div>
									<div class="redbubble" style="margin-bottom:-15px;">
										'.$downVotes.'
									</div>';
								}
					echo'
							</div>
							<a href="linkdetails.php?linkID='.$linkID.'" class="ui-link-inherit">
								<h3 class="ui-li-heading">'.stripslashes($title).'</h3>
								<p class="ui-li-desc">'.$mediaType.' - '.$views.' Views</p>
								<p class="ui-li-desc">Posted by '.$poster.'</p>
								<p class="ui-li-desc"> '.$tags.' </p>				
							</a>	
						</li>';
								
					}
					?>
				</ul>
			</div><!-- /content -->	
			<div data-role="footer" data-position="fixed" class="nav-glyphish-example">
				<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
					<ul>
						<li><a href="indexRefresh.html" id="home-icon" data-icon="custom" class="ui-btn-active">Home</a></li>
						<li><a href="browse.php" id="browse-icon" data-icon="custom">Browse</a></li>
						<li><a href="favorites.php" id="favorites-icon" data-icon="custom">Favorites</a></li>
						<li><a href="addlinkSubject.php" id="addlink-icon" data-icon="custom">Add Link</a></li>
					</ul>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
