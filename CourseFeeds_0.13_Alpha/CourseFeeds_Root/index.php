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
		<div data-role="page">
			<div data-role="panel" id="mypanel" class="ui-responsive" data-theme="d" data-position="right" data-display="overlay" data-dismissible="true">
				<?php include 'includes/panelCompact.php'; ?>				
			</div><!-- /panel -->
			<?php		
				$today = time(); //gets current date string
				$timestamp = $today - 604800; //sets timestamp to 7 days ago
				$newDate = date("Y-m-d H:i:s", $timestamp); //changes timestamp to date string	
				echo '
				<div data-role="header" data-theme="c" data-position="fixed">		
					<h1>
						<span style="font-size:14pt; color: #21445b;">
							CourseFeeds
						</span>
					</h1>			
					<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;">
						<img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" />
					</a>
				</div><!-- /header -->';
			?>
			<div data-role="content">			
				<?php
					if(logged_in() === true){ echo'
						<div class="content-secondary" style="margin: 0;">
						<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin: 0;">
							<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">
								My Courses
							</li>';
					
						//////////////////// My Courses ///////////////////
						$query = mysql_query("SELECT c.ID, c.Title as CourseTitle, c.Subject, s.IconPath, c.CourseNumber  
											FROM EnrolledCourses ec 
											INNER JOIN Courses c ON ec.CourseID = c.ID
											INNER JOIN Subject s ON c.Subject = s.Subject
											WHERE ec.User ='".$user_data['Name']."' AND ec.Archived = '0'");
						while($data	= mysql_fetch_array($query)){
							$subject = $data["Subject"];
							$length	=	strlen($subject);
							$start	= 	strlen($subject);
							
							/* finds the acronym by looking for a parenthesis */
							for($start; $start > 0 && $subject[$start] !='('; $start--){ 
								$end = $start; //sets the end to the beginning of the acronym
							}
							
							/* finds the end of the acronym */
							for($end; $end > 0 && $subject[$end] !=')'; $end++){
								/* increase start by one to get past the parenthesis and then end-start-1 is how many spots it reads */
								$subjectAcronym = substr($subject, $start+1, $end - $start - 1);
							}
							
							//NOT WORKING YET: Count Students Enrolled //
							$queryCount = "SELECT Count(*) as count FROM EnrolledCourses WHERE CourseID= '" .$data["CourseID"]."'"; //counts the students enrolled in the course
							$resultsCount = mysql_query($queryCount); //runs the query above
							$number	= mysql_fetch_assoc($resultsCount);  //gets the number of students enrolled
							
							//NOT WORKING YET: Count Links for Course //
							$queryLinks = "SELECT Count(*) as count FROM CourseLinks WHERE CourseID= '" .$data["CourseID"]."'"; //counts the students enrolled in the course
							$resultsLinks = mysql_query($queryLinks); //runs the query above
							$links = mysql_fetch_assoc($resultsLinks);  //gets the number of students enrolled
						
							echo'	
							<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" 
							class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li li-fix ui-btn-up-c">					
								<img src="'.$data["IconPath"].'_Full.png" alt="Subject Icon" class="thumbnail-fix"/>
								<div class="ui-li">
									<div class="ui-btn-text">
										<a href="course.php?courseID='.$data["ID"].'&courseName='.urlencode($data["CourseTitle"]).'&subject='.urlencode($data["Subject"]).'" class="ui-link-inherit">	
											<h3 class="ui-li-heading">
												'.$data["CourseTitle"].'
											</h3>
											<p class="ui-li-desc">
												'.$subjectAcronym.' - '.$data["CourseNumber"].'
											</p>
											<p class="ui-li-desc">Fall 2013</p> <!-- Temporary until # of links and students query is working -->
											<!--<p class="ui-li-desc">'.$links["count"].' links, '.$number["count"].' students</p>--> <!-- NEEDS WORK WITH QUERYING -->
											<div class="ui-icon icon-fix ui-icon-arrow-r ui-icon-shadow"></div>	<!-- right arrow, dont remove or alter -->
										</a>
									</div>
								</div>'; 
						};
						echo'
							</ul>
				</div>
				<div class="content-primary" style="margin:0;">
					<div style="height:20px;visibility:none;"></div><!-- Formatting workaround -->
					<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin:0;">	
						<li style="padding:0px !important;margin:0 0 -8px 0 !important;">	
							<div id="slideshow">
								<div>
									<img src="../images/index_slideshow/welcomeback.png" alt="sources" /> 
								</div>
								<div>
									<img src="../images/index_slideshow/sources.png" alt="sources" />
								</div>
								<div>
									<img src="../images/index_slideshow/team.png" alt="team photo" />
								</div>
								<div>
									<img src="../images/index_slideshow/venndiagram.png" alt="venn diagram" />
								</div>
								<div>
									<img src="../images/index_slideshow/opensource.png" alt="sources" /> 
								</div>
							</div>
						</li>	
						<li style="padding:0px !important;margin:0 !important;">
							<a href="browse.php?campus=University%20of%20Michigan-Dearborn">			
								<div>
									<img src="../images/special/UMDearborn.png" alt="UM-Dearborn" />
								</div>			
							</a>
						</li>			
						<li style="padding:0px !important;margin:0 !important;">
							<a href="courses.php?MOOC=Coursera">			
								<div>
									<img src="../images/special/Coursera.png" alt="Coursera" />
								</div>			
							</a>
						</li>
						<li style="padding:0px !important;margin:0 !important;">
							<a href="courses.php?MOOC=edX">		
								<div>
									<img src="../images/special/edX.png" alt="edX" />
								</div>		
							</a>
						</li>
					</ul>	
					<div style="height:20px;visibility:none;"></div><!-- Formatting workaround -->		
				</div>	
				<div class="content-secondary" style="margin:0;">		
							<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin:0;">
								<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-top" style="z-index:1000;">
								Twitter: @CFeeds
								</li>
								<li style="background:f7f7f7 !important;">
									<div style="margin: -15px;">
										<a class="twitter-timeline" height="283" data-dnt="true" href="https://twitter.com/CFeeds" data-widget-id="346390834347909121"></a>
										<script>
											!function(d,s,id){
												var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';
												if(!d.getElementById(id)){
													js=d.createElement(s);
													js.id=id;
													js.src=p+"://platform.twitter.com/widgets.js";
													fjs.parentNode.insertBefore(js,fjs);
												}
											}(document,"script","twitter-wjs");
										</script>
									</div>
								</li>
								<li style="padding:0;margin:0;">
									<div style="background-color:#e6e6e6; z-index:1001;height:6px;width:100%;padding:0;margin:-5px 0px 0px 0px;"></div>
								</li>
							</ul>
				</div>';
					}else{ echo' 
					<div class="content-secondary" style="margin:0;">	
								<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin:0;">
									<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-none">
										Welcome to CourseFeeds '.$version.'
									</li> 
									<li>
										<div class="ui-grid-a" style="margin-bottom:5px;">
											<div class="ui-block-a">
												<a href="register.php" data-role="button" data-mini="true" data-rel="dialog" data-transition="pop" data-theme="c" data-icon="plus" style="padding:0;">
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
									<li style="-moz-box-shadow: rgba(0, 0, 0, 0.296875) 0px 2px 4px 0px; -webkit-box-shadow: rgba(0, 0, 0, 0.296875) 0px 2px 4px 0px; box-shadow: rgba(0, 0, 0, 0.296875) 0px 2px 4px 0px;">
										<div>
											<a href="quickstart.php" target="_blank" data-role="button" data-theme="c" data-mini="true" data-ajax="false" data-icon="custom" id="quickstart2-icon" style="margin-left:2%;padding:0;width:95%;">
												Quick-Start Guide
											</a>
										</div>
									</li>
									<li style="-moz-box-shadow: rgba(0, 0, 0, 0.296875) 0px 2px 4px 0px; -webkit-box-shadow: rgba(0, 0, 0, 0.296875) 0px 2px 4px 0px; box-shadow: rgba(0, 0, 0, 0.296875) 0px 2px 4px 0px;">
										<div class="ui-grid-a" style="margin-bottom:5px;">
											<div class="ui-block-a">
												<a href="email.php" data-role="button" data-mini="true" data-rel="dialog" data-transition="pop" data-icon="custom" id="newsletter-icon" data-theme="c" style="padding:0;">
													Newsletter
												</a>
											</div>
											<div class="ui-block-b">
												<a href="https://github.com/CourseFeeds/cfeeds" target="_blank" data-role="button" data-mini="true" data-rel="dialog" data-transition="pop" data-icon="custom" id="fork-icon" data-theme="c" style="padding:0;">
													GitHub
												</a>
											</div>
										</div>
									</li>
								</ul>
				</div>				
				<div class="content-primary" style="margin:0;">
					<div style="height:20px;visibility:none;"></div><!-- Formatting workaround -->
					<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin:0;">	
						<li style="padding:0px !important;margin:0 0 -8px 0 !important;">	
							<div id="slideshow">
								<div>
									<img src="../images/index_slideshow/welcomeback.png" alt="sources" />
								</div>
								<div>
									<img src="../images/index_slideshow/sources.png" alt="sources" />
								</div>
								<div>
									<img src="../images/index_slideshow/team.png" alt="team photo" />
								</div>
								<div>
									<img src="../images/index_slideshow/venndiagram.png" alt="venn diagram" />
								</div>
								<div>
									<img src="../images/index_slideshow/opensource.png" alt="sources" /> 
								</div>
							</div>
						</li>	
						<li style="padding:0px !important;margin:0 !important;">
							<a href="browse.php?campus=University%20of%20Michigan-Dearborn">			
								<div>
									<img src="../images/special/UMDearborn.png" alt="UM-Dearborn" />
								</div>			
							</a>
						</li>			
						<li style="padding:0px !important;margin:0 !important;">
							<a href="courses.php?MOOC=Coursera">			
								<div>
									<img src="../images/special/Coursera.png" alt="Coursera" />
								</div>			
							</a>
						</li>
						<li style="padding:0px !important;margin:0 !important;">
							<a href="courses.php?MOOC=edX">		
								<div>
									<img src="../images/special/edX.png" alt="edX" />
								</div>		
							</a>
						</li>
					</ul>
					<div style="height:20px;visibility:none;"></div><!-- Formatting workaround -->			
				</div>	
				<div class="content-secondary" style="margin:0;">				
								<ul data-role="listview" data-inset="true" data-theme="d" data-dividertheme="d" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin:0;">
									<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-top" style="z-index:1000;">
									Twitter: @CFeeds
									</li>
									<li style="background:f7f7f7 !important;">
										<div style="margin: -15px;">
											<a class="twitter-timeline" height="283" data-dnt="true" href="https://twitter.com/CFeeds" data-widget-id="346390834347909121"></a>
											<script>
												!function(d,s,id){
													var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';
													if(!d.getElementById(id)){
														js=d.createElement(s);
														js.id=id;
														js.src=p+"://platform.twitter.com/widgets.js";
														fjs.parentNode.insertBefore(js,fjs);
													}
												}(document,"script","twitter-wjs");
											</script>
										</div>
									</li>
									<li style="padding:0;margin:0;">
										<div style="background-color:#e6e6e6; z-index:1001;height:6px;width:100%;padding:0;margin:-5px 0px 0px 0px;"></div>
									</li>
								</ul>
				</div>';
					}
				?>									
			</div><!-- /content -->	
			<!-- need to connect the pages, for some reason their is no connection between them -->
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
		<?php include 'includes/slideshow.php'; ?>
	</body>
</html>
