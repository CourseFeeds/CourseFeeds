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
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>
					<span style="font-size:14pt; color: #21445b;">
						Link Details
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;"><img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" /></a>
			</div><!-- /header -->
			<div data-role="content">
				<div class="content-secondary">
					<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="height:90px;margin-top:-5px; margin-bottom:15px;">
					<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ">Link View Options</li>	
					<?php 
					$linkID = htmlspecialchars($_GET["linkID"]); //this is used everywhere, just a note since many other things are only local not global local
					$query = "SELECT Subject, Poster, MediaType, URL, Title, Description, CreatedDate, TotalViews FROM SubjectLinks WHERE ID = '".$linkID."'";
					$result	= mysql_query($query);
					$row = mysql_fetch_array($result);
					$subject = $row["Subject"];
					$poster	= $row["Poster"];
					$media	= $row["MediaType"];
					$URL = $row["URL"];
					$title	= $row["Title"];
					$description = $row["Description"];
					$createdDate = $row["CreatedDate"];
					$views = $row["TotalViews"];
					$length	= strlen($subject);
					$start = strlen($subject);
					for($start; $start > 0 && $subject[$start] !='('; $start--){ //finds the acronym by looking for a (
						$end = $start; //sets the end to the beginning of the acronym
					}
					for($end; $end > 0 && $subject[$end] !=')'; $end++){ //finds the end of the acronym
						$subjectAcronym = substr($subject, $start+1, $end - $start - 1); //increase start by one to get past the ( and then end-start-1 is how many spots it reads
					}	
					//shows the beam button if it is a beamable media)(i.e. video)
					if($media == "YouTube Video"){
						$orgURL = $URL;
						$start = 0;
						$end = 0;
						for($start; $start < strlen($URL) && ($URL[$start] !='v' && $URL[$start+1] !='='); $start++){ //finds the variable of the video link
							$URL = substr($URL, $start+2); //restarts the string where the variable starts
						}
						for($end; $end <strlen($URL) && $URL[$end] != '&'; $end++){ //finds the end of the variable
							$URL = substr($URL, 0, $end);//saves the variable
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
							$start	=  strlen($URL); //adjusting to find the variable of vimeo videos which is located at the end of the URL
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
					}?>			
						</ul>
						<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin-bottom:15px;">
							<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ">
								Link Description
							</li>
							<?php
							echo'
							<li style="font-size:10pt; font-weight:normal;">
								'.stripslashes($description).'
							</li>';
							?>
						</ul>	
					</div>
					<div class="content-primary" style="margin-top:10px;">
						<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
							<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ">
								Link Information
							</li>
							<?php 
							echo'
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
								Admin
							</li>
						</ul>';
						//code for youtube video that is currently set for all video's, although it needs to be changed
						if($media == "YouTube Video"){ // if mediatype is Video, embed video in page
							echo '
							<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
								<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ">
									'.stripslashes($title).'
								</li>
								<li>
									<iframe src="'.$youtubeEmbedded. '" width="100%" height="315px" id="iframe1" marginheight="0" frameborder="0" onLoad="autoResize(\'iframe1\');"></iframe>      
								</li>
							</ul>';
						}else if($media == "Vimeo Video"){ // if mediatype is Vimeo_Video, it embeds the video in page
							echo'
							<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
								<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d ">
									'.stripslashes($title).'
								</li>
								<li> 
									<iframe src="'.$vimeoEmbedded.'" width="100%" height="375" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>	  
								</li>
							</ul>';
						}?>		
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
