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
			$linkID = htmlspecialchars($_GET["linkID"]); //this is used everywhere, just a note since many other things are only local not global local
			$currentVote= htmlspecialchars($_GET["currentVote"]);
			$voteLinkID = htmlspecialchars($_GET["voteLinkID"]);
			$error = false;
			mysql_query("UPDATE CourseLinks SET TotalViews = TotalViews + 1 WHERE ID = ".$linkID.""); //updates the views of the page	
			if($voteLinkID==''){	//This is here to check for variables indicating that the user has voted and what their vote was if they did
				$error = true;
			}else if($currentVote==''){
				$error = true;
			}		
			if($error == false){
				$results 		= mysql_query("SELECT Count(*) as count FROM UserCourseLinkVotes WHERE CourseLinkID = '".$voteLinkID."' AND Voter='".$user_data['Name']."'");
				$row 			= mysql_fetch_assoc($results);//checks to see if the user has voted
				$positive 		= mysql_query("SELECT UpVote FROM UserCourseLinkVotes WHERE CourseLinkID = '".$voteLinkID."' AND Voter='".$user_data['Name']."'");
				$positiveVote	= mysql_fetch_array($positive);//Checks if the users vote was a positive vote or a negative vote.	
			}			
			if($row["count"] == 0){ //checks if the user has voted
				$haveVoted	= false;
			}else{ 
				$haveVoted = true;
			}
			if($haveVoted == true && $currentVote == 1){ //checks if the user has voted and wants to vote up
				if($positiveVote["UpVote"] == 0){ //sees if the user voted down previously
					mysql_query("UPDATE CourseLinks SET UpVotes= UpVotes+1 , DownVotes= DownVotes-1 WHERE ID = '".$voteLinkID."'"); //removes a downvote and adds an upvote
					mysql_query("UPDATE UserCourseLinkVotes SET UpVote= 1 WHERE CourseLinkID = '".$voteLinkID."'");//updates the overall votes
					mysql_query("UPDATE CourseLinks SET LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'"); //updates the last rated date
					mysql_query("UPDATE CourseLinks SET TotalViews = TotalViews - 1 WHERE ID = ".$linkID."");//prevents view counter from becoming incorrect
					header('Location: linkdetails.php?linkID='.$linkID.''); //instantly reloads the page so the correct votes will appear
				}else{
					mysql_query("UPDATE CourseLinks SET UpVotes= UpVotes-1 WHERE ID = '".$voteLinkID."'"); //cancels out the users previous vote (upvote in this case)
					mysql_query("DELETE FROM UserCourseLinkVotes WHERE Voter= '".$user_data['Name']."' AND CourseLinkID= '".$voteLinkID."'"); //deletes the fact that the user has voted
					mysql_query("UPDATE CourseLinks SET LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'");
					mysql_query("UPDATE CourseLinks SET TotalViews = TotalViews - 1 WHERE ID = ".$linkID."");
					header('Location: linkdetails.php?linkID='.$linkID.''); //instantly reloads the page so the correct votes will appear
				}
			}
			if($haveVoted == true && $currentVote == 0){//checks if the user has voted and wants to vote down
				if($positiveVote["UpVote"] == 1){ //sees if the user voted up previously on the link
					mysql_query("UPDATE CourseLinks SET UpVotes= UpVotes-1 , DownVotes= DownVotes+1 WHERE ID = '".$voteLinkID."'"); //removes an upvote and adds an downvote to the link
					mysql_query("UPDATE UserCourseLinkVotes SET UpVote= 0 WHERE CourseLinkID = '".$voteLinkID."'");
					mysql_query("UPDATE CourseLinks SET LastRatedDate = NOW() WHERE CourseLinkID = '".$voteLinkID."'");
					mysql_query("UPDATE CourseLinks SET TotalViews = TotalViews - 1 WHERE ID = ".$linkID."");
					header('Location: linkdetails.php?linkID='.$linkID.''); //instantly reloads the page so the correct votes will appear
				}else{
					mysql_query("UPDATE CourseLinks SET DownVotes= DownVotes-1 WHERE ID = '".$voteLinkID."'"); //cancels out the users previous vote (downvote in this case)
					mysql_query("DELETE FROM UserCourseLinkVotes WHERE Voter= '".$user_data['Name']."' AND  CourseLinkID= '".$voteLinkID."'"); //deletes the fact that the user has voted
					mysql_query("UPDATE CourseLinks SET LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'");
					mysql_query("UPDATE CourseLinks SET TotalViews = TotalViews - 1 WHERE ID = ".$linkID."");
					header('Location: linkdetails.php?linkID='.$linkID.''); //instantly reloads the page so the correct votes will appear
				}
			}
			if($haveVoted == false && $currentVote == 0){ //checks if the user has not voted and wants to vote down
				mysql_query("UPDATE CourseLinks SET DownVotes= DownVotes+1 WHERE ID = '".$voteLinkID."'"); //adds a downvote to the current link
				mysql_query("INSERT INTO UserCourseLinkVotes (Voter, CourseLinkID, UpVote) VALUES ('".$user_data['Name']."', '".$voteLinkID."', '0')"); //inserts that the user has now voted
				mysql_query("UPDATE CourseLinks SET LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'");
				mysql_query("UPDATE CourseLinks SET TotalViews = TotalViews - 1 WHERE ID = ".$linkID."");
				header('Location: linkdetails.php?linkID='.$linkID.''); //instantly reloads the page so the correct votes will appear
			}
			if($haveVoted == false && $currentVote == 1){ //checks if the user has note voted and wants to vote up
				mysql_query("UPDATE CourseLinks SET UpVotes= UpVotes+1 WHERE ID = '".$voteLinkID."'"); //adds an upvote to the current link
				mysql_query("INSERT INTO UserCourseLinkVotes (Voter, CourseLinkID, UpVote) VALUES ('".$user_data['Name']."', '".$voteLinkID."', '1')"); //inserts that the user has now voted
				mysql_query("UPDATE CourseLinks SET LastRatedDate = NOW() WHERE ID = '".$voteLinkID."'");
				mysql_query("UPDATE CourseLinks SET TotalViews = TotalViews - 1 WHERE ID = ".$linkID."");
				header('Location: linkdetails.php?linkID='.$linkID.''); //instantly reloads the page so the correct votes will appear
			}			
			?>
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>
					<span style="font-size:14pt; color: #21445b;">
						CourseFeeds
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;">
					<img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" />
				</a>
			</div><!-- /header -->			
			<div data-role="content">			
				<div class="content-secondary">		
					<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="height:90px;margin-top:-5px; margin-bottom:15px;">
						<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-none">
							Link View Options
						</li>	
						<?php 
						$query = "SELECT Subject, Poster, MediaType, CourseID, URL, Title, Description, CreatedDate, UpVotes, DownVotes, TotalViews, LastRatedDate FROM CourseLinks WHERE ID = '".$linkID."'";
						$result = mysql_query($query);
						$row = mysql_fetch_array($result);
						$subject = $row["Subject"];
						$poster = $row["Poster"];
						$media = $row["MediaType"];
						$courseID = $row["CourseID"];
						$URL = $row["URL"];
						$title = $row["Title"];
						$description = $row["Description"];
						$createdDate = $row["CreatedDate"];
						$upVotes = $row["UpVotes"];
						$downVotes = $row["DownVotes"];
						$views = $row["TotalViews"];						
						$length = strlen($subject);
						$start = strlen($subject);
						for($start; $start > 0 && $subject[$start] !='('; $start--); //finds the acronym by looking for a (
						$end = $start; //sets the end to the beginning of the acronym
						for($end; $end > 0 && $subject[$end] !=')'; $end++);//finds the end of the acronym
						$subjectAcronym	= substr($subject, $start+1, $end - $start - 1); //increase start by one to get past the ( and then end-start-1 is how many spots it reads
						//yes this is confusing, but I don't have a better way to get it at the moment							
						$courseResults = mysql_query("SELECT Title, CourseNumber FROM Courses WHERE ID='".$courseID."'");
						$courseRow = mysql_fetch_array($courseResults);
						$courseName	= $courseRow["Title"];
						$courseNumber = $courseRow["CourseNumber"];						
						//shows the beam button if it is a beamable media)(i.e. video)
						if($media == "YouTube Video"){ //displaying issues here when no user is logged in, not sure why
							$orgURL = $URL;
							$start = 0;
							$end =  0;
							for($start; $start < strlen($URL) && ($URL[$start] !='v' && $URL[$start+1] !='='); $start++){ //finds the variable of the video link
								$URL = substr($URL, $start+2); //restarts the string where the variable starts
							}
							for($end; $end <strlen($URL) && $URL[$end] != '&'; $end++){ //finds the end of the variable
								$URL = substr($URL, 0, $end); //saves the variable
							}
							$youtubeEmbedded = "http://www.youtube.com/embed/".$URL.""; //puts the video into the youtube embedded format						
							echo'
							<div class="ui-grid-a" style="margin-top:8px;">
								<div class="ui-block-a">
									<a href="'.$orgURL.'" target="_blank" data-role="button" data-theme="b" id="play-icon" data-mini="true" data-icon="custom" style="padding:0;">
										View
									</a>
								</div>
								<div class="ui-block-b">
									<a href="beam.php?URL='.urlencode($orgURL).'&media='.$media.'&embed='.urlencode($youtubeEmbedded).'" target="_blank" data-role="button" id="beam-icon" data-mini="true" data-icon="custom" style="padding:0;">
										Beam
									</a>
								</div>
							</div>';
						}else if($media == "Vimeo Video"){
							$orgURL = $URL; //saves the original url since the url is altered
							$length	= strlen($URL); //saves the length of the URL
							$start	= strlen($URL); //adjusting to find the variable of vimeo videos which is located at the end of the URL
							for($start; $start > 0 && $URL[$start] !='/'; $start--){ //finds the variable of the video link
								$start = $start - $length;
							}
							$URL = substr($URL, $start+1); //restarts the string where the variable starts which is a set number of spaces from the end of the string
							$vimeoEmbedded = "http://player.vimeo.com/video/".$URL."";										
							echo'
							<div class="ui-grid-a" style="margin-top:8px;">
								<div class="ui-block-a">
									<a href="'.$orgURL.'" target="_blank" data-role="button" data-theme="b" id="play-icon" data-mini="true" data-icon="custom" style="padding:0;">
										View
									</a>
								</div>
								<div class="ui-block-b">
									<a href="beam.php?URL='.urlencode($orgURL).'&media='.urlencode($media).'&embed='.urlencode($vimeoEmbedded).'" " target="_blank" data-role="button" id="beam-icon" data-mini="true" data-icon="custom" style="padding:0;">
										Beam
									</a>
								</div>
							</div>';
						}else{
							echo'
							<div style="margin-top:12px;">
								<a href="'.$URL.'" target="_blank" data-role="button" data-theme="b" id="play-icon" data-mini="true" data-icon="custom" style="padding:0;margin-left:15px;margin-right:15px;">
									<span style="color:white;">
										View
									</span>
								</a>
							</div>';
						}
						?>			
						</ul>						
						<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin-bottom:15px;">
							<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-none">
								Link Description
							</li>
							<?php echo'
							<li style="font-size:10pt; font-weight:normal;">
								'.stripslashes($description).'
							</li>';?>
						</ul>						
						<?php 
						$results = mysql_query("SELECT Count(*) as count FROM Favorites WHERE CourseLinkID = '".$linkID."' AND User='".$user_data['Name']."'");
						$row = mysql_fetch_assoc($results);
						if(logged_in() === false){	
							// do nothing
						}else if($user_data['Name'] != $poster AND $user_data['IsModerator'] != '1'){ // Determines whether to display delete or report button. If the user is that same as the poster, it is delete; otherwise it is report.			
							echo'
							<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="c" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
								<li>';
								if($row["count"] !=0){ //disables the button if the user already has it favorited and changes what it says
									echo'
									<div class="ui-grid-a">
										<div class="ui-block-a">
											<a data-role="button" data-rel="dialog" data-transition="pop" data-theme="e" data-icon="star" data-mini="true" data-rel="dialog" data-transition="pop" style="padding:0;">
												Starred
											</a>
										</div>
										<div class="ui-block-b">
											<a href="reportLink.php?reportLink='.$linkID.'" data-role="button" data-rel="dialog" data-transition="pop" data-icon="alert" data-mini="true" style="padding:0;">
												Report
											</a>
										</div>
									</div>';
								}else{
									echo'
									<div class="ui-grid-a">
										<div class="ui-block-a">
											<a href="star.php?linkID='.$linkID.'" data-role="button" data-rel="dialog" data-transition="pop" data-theme="e" data-icon="star" data-mini="true" data-rel="dialog" data-transition="pop" style="padding:0;">
												Star
											</a>
										</div>
										<div class="ui-block-b">
											<a href="reportLink.php?reportLink='.$linkID.'" data-role="button" data-rel="dialog" data-transition="pop" data-icon="alert" data-mini="true" style="padding:0;">
												Report
											</a>
										</div>
									</div>';
								}
						}else{
							echo'
							<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="c" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
								<li>';
							if($row["count"] !=0){ //disables the button if the user already has it favorited and changes what it says
								echo'
								<div class="ui-grid-a">
									<div class="ui-block-a">
										<a data-role="button" data-rel="dialog" data-transition="pop" data-theme="e" data-icon="star" data-mini="true" data-rel="dialog" data-transition="pop" style="padding:0;">
											Starred
										</a>
									</div>
									<div class="ui-block-b">
										<a href="deleteLink.php?linkID='.$linkID.'" data-role="button" data-rel="dialog" data-transition="pop" data-icon="alert" data-mini="true" style="padding:0;">
											Delete
										</a>
									</div>
								</div>';
							}else{
								echo'
								<div class="ui-grid-a">
									<div class="ui-block-a">
										<a href="star.php?linkID='.$linkID.'" data-role="button" data-rel="dialog" data-transition="pop" data-mini="true" data-theme="e" data-icon="star" data-rel="dialog" data-transition="pop" style="padding:0;">
											Star
										</a>
									</div>
									<div class="ui-block-b">
										<a href="deleteLink.php?linkID='.$linkID.'" data-role="button" data-rel="dialog" data-transition="pop" data-icon="alert" data-mini="true" style="padding:0;">
											Delete
										</a>
									</div>
								</div>';
							}
						}
						?>
								</li>
							</ul>
						</div>					
						<div class="content-primary" style="margin-top:10px;">					
							<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
								<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-none">
									Link Information
								</li>
								<?php echo'
								<li class="ui-li" style="font-size: 16pt;">
									'.stripslashes($title).' 
								</li>
								<li class="ui-li" style="height:20px;">     
									<div style="float: left; font-size: 12pt; font-weight: bold;">
										'.$media.'
									</div>
									<div style="float: right; font-size: 12pt; font-weight: bold; margin-right:25px;">
										'. $views .' views
									</div>
								</li>
								<li class="ui-li">
									<a href="course.php?courseID='.$courseID.'&courseName='.urlencode($courseName).'&subject='.urlencode($subject).'"">
										'.$courseName.' 
									</a>
								</li>
								<li class="ui-li">
									<a href="student.php?poster='.$poster.'">
										'.$poster.' 
									</a>
								</li>	
							</ul>';
							//code for youtube video that is currently set for all video's, although it needs to be changed
							if($media == "YouTube Video"){ // if mediatype is Video, embed video in page
								echo '
								<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
									<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-none">
										'.stripslashes($title).'
									</li>
									<li>
										<iframe src="'.$youtubeEmbedded. '" width="100%" height="315px" id="iframe1" marginheight="0" frameborder="0" onLoad="autoResize(\'iframe1\');"></iframe>      
									</li>
								</ul>';
							}else if($media == "Vimeo Video"){ // if mediatype is Vimeo_Video, it embeds the video in page
								echo '
								<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
									<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ui-corner-none">
										'.stripslashes($title).'
									</li>	
									<li>					
										<iframe src="'.$vimeoEmbedded.'" width="100%" height="375" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
									</li>
								</ul>';
							}			
							echo'
							<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="c" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">				
								<li>';
									$counting = mysql_query("SELECT Count(*) as count, UpVote FROM UserCourseLinkVotes WHERE CourseLinkID = '".$linkID."' AND Voter='".$user_data['Name']."'");
									$positiveVote = mysql_fetch_assoc($counting);
									//The coloration of the buttons is off and needs to be adjusted
									if (logged_in() === true){ //displays for logged in users so they can vote on links
										if($positiveVote["UpVote"] == 1){ //if the user has a voted positively on a link
											echo'
											<div class="ui-grid-a">
												<div class="ui-block-a">
													<a href="#" onclick="window.location=\'linkdetails.php?linkID='.$linkID.'&currentVote=1&voteLinkID='.$linkID.'\';" data-role="button" data-theme="gv" data-icon="check" data-mini="true" style="padding:0;">
														<span style="color:white; font-size:20pt;padding:0;white-space:normal;margin-left:-30px;">
															'.$upVotes.'
														</span>
													</a>
												</div>
												<div class="ui-block-b">
													<a href="#" onclick="window.location=\'linkdetails.php?linkID='.$linkID.'&currentVote=0&voteLinkID='.$linkID.'\';" data-role="button" data-theme="r" data-icon="minus" data-mini="true" style="padding:0;">
														<span style="color:white; font-size:20pt;padding:0;white-space:normal;margin-left:-30px;">
															'.$downVotes.'
														</span>
													</a>
												</div>
											</div>';
										}else if($positiveVote["UpVote"] == 0 && $positiveVote["count"] != 0){ //if the user has voted negatively on a link
											echo'
											<div class="ui-grid-a">
												<div class="ui-block-a">
													<a href="#" onclick="window.location=\'linkdetails.php?linkID='.$linkID.'&currentVote=1&voteLinkID='.$linkID.'\';" data-role="button" data-theme="g" data-icon="plus" data-mini="true" style="padding:0;">
														<span style="color:white; font-size:20pt;padding:0;white-space:normal;margin-left:-30px;">
															'.$upVotes.'
														</span>
													</a>
												</div>
												<div class="ui-block-b">
													<a href="#" onclick="window.location=\'linkdetails.php?linkID='.$linkID.'&currentVote=0&voteLinkID='.$linkID.'\';" data-role="button" data-theme="rv" data-icon="check" data-mini="true" style="padding:0;">
														<span style="color:white; font-size:20pt;padding:0;white-space:normal;margin-left:-30px;">
															'.$downVotes.'
														</span>
													</a>
												</div>
											</div>';
										}else{ //if the user has not voted on the link yet
											echo'
											<div class="ui-grid-a">
												<div class="ui-block-a">
													<a href="#" onclick="window.location=\'linkdetails.php?linkID='.$linkID.'&currentVote=1&voteLinkID='.$linkID.'\';" data-role="button" data-theme="g" data-icon="plus" data-mini="true" style="padding:0;">
														<span style="color:white; font-size:20pt;padding:0;white-space:normal;margin-left:-30px;">
															'.$upVotes.'
														</span>
													</a>
												</div>
												<div class="ui-block-b">
													<a href="#" onclick="window.location=\'linkdetails.php?linkID='.$linkID.'&currentVote=0&voteLinkID='.$linkID.'\';" data-role="button" data-theme="r" data-icon="minus" data-mini="true" style="padding:0;">
														<span style="color:white; font-size:20pt;padding:0;white-space:normal;margin-left:-30px;">
															'.$downVotes.'
														</span>
													</a>
												</div>
											</div>';
										}
									}else{ //does not allow a click action if the user is not logged in
										echo'
										<div class="ui-grid-a">
											<div class="ui-block-a">
												<a href="#" data-role="button" data-theme="g" data-icon="plus" data-mini="true" style="padding:0;">
													<span style="color:white; font-size:20pt;padding:0;white-space:normal;margin-left:-30px;">
														'.$upVotes.'
													</span>
												</a>
											</div>
											<div class="ui-block-b">
												<a href="#" data-role="button" data-theme="r" data-icon="minus" data-mini="true" style="padding:0;">
													<span style="color:white; font-size:20pt;padding:0;white-space:normal;margin-left:-30px;">
														'.$downVotes.'
													</span>
												</a>
											</div>
										</div>';
									}					
									$query = "SELECT ID, Poster, Comment, CreatedDate FROM Comments WHERE CourseLinkID = '".$linkID."' ORDER BY CreatedDate DESC";
									$results = mysql_query($query);
									echo'
								</li>	
							</ul>
					<form action="submitcomment.php" method="get">
							<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="c" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
								<li>
									<div data-role="collapsible">
										<h3> 
											Comments 
										</h3>
										<ul>';
									while($row	= mysql_fetch_assoc($results)){ //outputting all of the comments with a given link					{
										echo'
											<li data-corners="false" data-shadow="false" data-wrapperels="div" data-theme="c" class="ui-li" style="margin-top:30px; height:110px;">
												<span style="font-weight:bold;">
													'.$row["Poster"].' - '.$row["CreatedDate"].' 
												</span>
												<div style="margin-top:5px; margin-left:10px; background:#feffdb;">
													'.$row["Comment"].'
												</div>';
												if($user_data['Name'] != $row["Poster"]){ //Determines whether to display delete or report based on whether the link submitter and the currently signed in user is the same
													echo'
													<a href="reportComment.php?reportCommentID='.$row["ID"].'&linkID='.$linkID.'" data-role="button" data-rel="dialog" data-transition="pop" data-icon="alert"  data-mini="true" style="padding:0; width:90px; float:right; margin-top:5px;">
														Report
													</a>';
												}else{ 
													echo'
													<a href="deleteComment.php?commentID='.$row["ID"].'&linkID='.$linkID.'" data-role="button"  data-rel="dialog" data-transition="pop" data-mini="true" data-icon="alert" style="padding:0; width:90px; float:right; margin-top:5px;">
														Delete
													</a>';
												}
									}
										echo'
											</li>
											<li data-corners="false" data-shadow="false" data-role="fieldcontain" data-wrapperels="div" data-theme="c" class="ui-li" style="height:160px; border-style:none;">
												<div style="margin-top:10px;">
													<label for="textarea-a" class="ui-input-text">
														Comment: 
													</label>
													<textarea name="textarea" id="textarea-a" maxlength="140" class="ui-input-text ui-body-c ui-corner-none ui-shadow-inset" style="width:100%;height:140px;margin-top:5px;"></textarea>
												</div>
											</li>
											<li style="margin-top:50px;">
												<button type="submit" data-theme="b" name="submit" value="'.$linkID.'" class="ui-btn-hidden" aria-disabled="false">
													Submit Comment
												</button>
											</li>	
										</ul>
									</div><!-- Collapsible -->
								</li>
							</ul>
						</form>';?>		
					</div>	
			</div><!-- /content -->	
			<div data-role="footer" data-position="fixed" class="nav-glyphish-example">
				<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
					<ul>
						<li><a href="indexRefresh.html" id="home-icon" data-icon="custom">Home</a></li>
						<li><a href="browse.php" id="browse-icon" data-icon="custom" class="ui-btn-active">Browse</a></li>
						<li><a href="favorites.php" id="favorites-icon" data-icon="custom">Favorites</a></li>
						<li><a href="addlinkSubject.php" id="addlink-icon" data-icon="custom">Add Link</a></li>
					</ul>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
