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
	if(logged_in() === true){
		echo ' 
		<div data-role="page">
			<div data-role="panel" id="mypanel" class="ui-responsive" data-theme="d" data-position="right" data-display="overlay" data-dismissible="true">
				<ul data-role="listview" data-theme="d" data-divider-theme="d" class="nav-search">
					<li id="menuSmall-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
						<a href="#" data-rel="close">
							<span style="margin-left:22px;">
								Close Menu
							</span>
						</a>
					</li>
					<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">
						Account Options
					</li>';
					$campus = $user_data['Campus'];
					echo'
					<li>
						User: '.$user_data['Name'].'
					</li>
					<li class="active ui-btn-icon-left" id="logout-icon" data-icon="custom" data-icon-pos="left">
						<a href="logout.php">
							<span style="margin-left:22px;">
								Sign Out
							</span>
						</a>
					</li>
					<li id="settings-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left"><a href="settings.php" data-rel="dialog" data-transition="pop"><span style="margin-left:22px;">Settings</span></a></li>
					';
					?>
					<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">
						General Information
					</li>
					<li id="about-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
						<a href="about.php" data-rel="dialog" data-transition="pop">
							<span style="margin-left:22px;">
								About
							</span>
						</a>
					</li>
					<li id="campusReq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
						<a href="requestCampus.php" data-rel="dialog" data-transition="pop">
							<span style="margin-left:22px;">
								Request Campus
							</span>
						</a>
					</li>
					<li id="faq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
						<a href="techSupport.php" data-rel="dialog" data-transition="pop">
							<span style="margin-left:22px;">
								Technical Support
							</span>
						</a>
					</li>
					<li id="modApp-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
						<a href="modApp.php" data-rel="dialog" data-transition="pop">
							<span style="margin-left:22px;">
								Moderator Application
							</span>
						</a>
					</li>
					<li id="bugReport-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
						<a href="reportBug.php" data-rel="dialog" data-transition="pop">
							<span style="margin-left:22px;">
								Report Bug
							</span>
						</a>
					</li>
					<li id="legal-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
						<a href="legal.php" data-rel="dialog" data-transition="pop">
							<span style="margin-left:22px;">
								Legal
							</span>
						</a>
					</li>
					<?php
						echo'
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">
							My Courses
						</li>';
						///////////////////////// My Courses //////////////////////////
						$query = mysql_query("SELECT c.ID, c.Title as CourseTitle, c.Subject, s.IconPath, c.CourseNumber  
								 FROM EnrolledCourses ec 
								 INNER JOIN Courses c ON ec.CourseID = c.ID
								 INNER JOIN Subject s ON c.Subject = s.Subject
								 WHERE ec.User ='".$user_data['Name']."' AND ec.Archived = '0'");
						while($data = mysql_fetch_array($query)){
							$subject = $data["Subject"];
							//// my confusing code to get us the acronym ////
							$length	= strlen($subject);
							$start	= strlen($subject);
							for($start; $start > 0 && $subject[$start] !='('; $start--){ //finds the acronym by looking for a (
								$end = $start; //sets the end to the beginning of the acronym
							}
							for($end; $end > 0 && $subject[$end] !=')'; $end++){ //finds the end of the acronym
								$subjectAcronym	= substr($subject, $start+1, $end - $start - 1); //increase start by one to get past the ( and then end-start-1 is how many spots it reads
							}
							echo'
							<li>
								<a href="course.php?courseID='.$data["ID"].'&courseName='.urlencode($data["CourseTitle"]).'&subject='.urlencode($data["Subject"]).'" class="ui-link-inherit">											
									'. $data["CourseTitle"] .'								
								</a>	
							</li>';
						}
					/////////////////////////
					?>
				</ul>
			</div><!-- /panel -->
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>
					<span style="font-size:14pt; color: #21445b;">
						Favorites
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;"><img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" /></a>
			</div><!-- /header -->		
			<div data-role="content">		
				<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-listview ui-corner-none ui-listview-inset ui-shadow" style="margin-top:15px;margin-left:15px;margin-right:15px;">
					<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d"> 		
						<span style="font-size:12pt;">
							Fall 2013 - <?php echo $campus;?>
						</span>
						<!-- Export Favorites disabled, incomplete functionality -->
						<!--
						<div data-type="horizontal" style="margin-top:-9px;float:right;margin-right:-8px;">		
						<a href="#" data-inline="true" data-theme="c" data-mini="true" data-role="button" style="border-style:none;">Export</a>		
						</div>
						-->
					</li>
				</ul>
				<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="e" data-split-icon="delete" data-split-theme="d" class="ui-listview ui-corner-none ui-listview-inset ui-shadow" style="margin: 0 15px 0 15px;">		
					<!-- Starred Links is for manually bookmarked links -->
					<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-e">
						Sorted by Date 
					</li>
					<?php		
					$query = mysql_query("SELECT cl.ID, cl.Subject, cl.Poster, cl.MediaType, cl.Title, cl.Description, cl.UpVotes, cl.DownVotes, cl.TotalViews, s.IconPath,
						 (SELECT GROUP_CONCAT(clt.Tag SEPARATOR ', ') FROM  CourseLinkTags AS clt WHERE  clt.CourseLinkID =  cl.ID) AS Tags  
						 FROM Favorites f
						 INNER JOIN CourseLinks cl ON f.CourseLinkID = cl.ID
						 INNER JOIN Subject s ON s.Subject = cl.Subject
						 WHERE f.User ='".$user_data['Name']."' ORDER BY f.ID DESC"); // fetch the necessary data
					while($data	= mysql_fetch_array($query)){				
						$tags = $data["Tags"];
						echo'
						<li style="height:120px;">
							<div style="float:left;">
								<img src="'.$data["IconPath"].'.png" alt="Subject Icon" width="90px" height="90px" class="thumbnail-fix" style="width:90px !important;height:90px !important;" />'; 
								if($tags){ // Special fomatting needed when the link has tags
									echo '
									<div class="greenbubble">
										'.$data["UpVotes"].'
									</div>
									<div class="redbubble">
										'.$data["DownVotes"].'
									</div>'; 
								}else{
									echo '
									<div class="greenbubble" style="margin-bottom:-15px;">
										'.$data["UpVotes"].'
									</div>
									<div class="redbubble" style="margin-bottom:-15px;">
										'.$data["DownVotes"].'
									</div>';
								}
									echo'
							</div>
							<a href="linkdetails.php?linkID='.$data["ID"].'" class="ui-link-inherit">
								<h3 class="ui-li-heading">'.stripslashes($data["Title"]).'</h3>
								<p class="ui-li-desc">'.$data["MediaType"].' - '.$data["TotalViews"].' Views</p>
								<p class="ui-li-desc">Posted by '.$data["Poster"].'</p>
								<p class="ui-li-desc"> '.$tags.' </p>				
							</a>';
							echo '
							<a href="unstar.php?linkID='.$data["ID"].'" data-rel="dialog" data-transition="pop up" style="margin-top:-1px;">';
							//<!-- Extra "a href" element is for unstar button, passes linkID variable to unstar.php page for removal from starred list -->
								echo '	
							</a>	
						</li>';
					}
					?>
				</ul>
			</div><!-- /content -->	
			<!-- Display on favorites.php when the user isn't signed in. 10/17/12 CW-->
	<?php	
	}else{
				echo '
				<div data-role="page" style="background-image:url(\'images/special/backgrounds/active_backgrounds/favoritesBackground.jpg\');background-size:cover; background-repeat:no-repeat !important;">
					<div data-role="panel" id="mypanel" class="ui-responsive" data-theme="d" data-position="right" data-display="overlay" data-dismissible="true">
						<ul data-role="listview" data-theme="d" data-divider-theme="d" class="nav-search">
							<li id="menuSmall-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
								<a href="#" data-rel="close">
									<span style="margin-left:22px;">
										Close Menu
									</span>
								</a>
							</li>
							<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">
								Account Options
							</li>
							<li class="active ui-btn-icon-left" id="login-icon" data-icon="custom" data-icon-pos="left">
								<a href="loginForm.php" data-rel="dialog" data-transition="pop">
									<span style="margin-left:22px;">
										Sign In
									</span>
								</a>
							</li>
							<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">
								General Information
							</li>
							<li id="about-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
								<a href="about.php" data-rel="dialog" data-transition="pop">
									<span style="margin-left:22px;">
										About
									</span>
								</a>
							</li>
							<li id="campusReq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
								<a href="requestCampus.php" data-rel="dialog" data-transition="pop">
									<span style="margin-left:22px;">
										Request Campus
									</span>
								</a>
							</li>
							<li id="faq-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
								<a href="techSupport.php" data-rel="dialog" data-transition="pop">
									<span style="margin-left:22px;">
										Technical Support
									</span>
								</a>
							</li>
							<li id="modApp-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
								<a href="modApp.php" data-rel="dialog" data-transition="pop">
									<span style="margin-left:22px;">
										Moderator Application
									</span>
								</a>
							</li>
							<li id="bugReport-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
								<a href="reportBug.php" data-rel="dialog" data-transition="pop">
									<span style="margin-left:22px;">
										Report Bug
									</span>
								</a>
							</li>
							<li id="legal-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
								<a href="legal.php" data-rel="dialog" data-transition="pop">
									<span style="margin-left:22px;">
										Legal
									</span>
								</a>
							</li>
						</ul>
						<!-- panel content goes here -->
					</div><!-- /panel -->
					<div data-role="header" data-theme="c" data-position="fixed">		
						<h1>
							<span style="font-family:Avenir Next;font-size:14pt; color: #21445b;">
								Favorites
							</span>
						</h1>			
						<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;">
							<img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" />
						</a>
					</div><!-- /header -->		
					<!-- Note: Content tags removed to fix background repeat bug caused by slide-out panel -->			
					<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="c" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin: 10% 3% 10% 3%;opacity:0.75;">
						<li style="opacity:1.0;">
							<div style="text-align:center;font-size:24pt;padding:10px;">
								Please Sign In to Access this Feature
							</div>
							<div class="ui-grid-a">
								<div class="ui-block-a">
									<a href="register.php" data-role="button" data-mini="true" data-rel="dialog" data-theme="c" data-icon="plus" data-rel="dialog" data-transition="pop" style="padding:0;">
										Register
									</a>
								</div>
								<div class="ui-block-b">
									<a href="loginForm.php" data-role="button" data-mini="true" data-rel="dialog" data-transition="pop" data-icon="custom" id="signInBlue-icon" data-theme="b" style="padding:0;">
										Sign In
									</a>
								</div>
							</div>
						</li>
					</ul>';
			}		
			?>
			<div data-role="footer" data-position="fixed" class="nav-glyphish-example">
				<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
					<ul>
						<li><a href="indexRefresh.html" id="home-icon" data-icon="custom">Home</a></li>
						<li><a href="browse.php" id="browse-icon" data-icon="custom">Browse</a></li>
						<li><a href="favorites.php" id="favorites-icon" data-icon="custom" class="ui-btn-active">Favorites</a></li>
						<li><a href="addlinkSubject.php" id="addlink-icon" data-icon="custom">Add Link</a></li>
					</ul>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
