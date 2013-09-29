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
						Subjects
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;">
					<img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" />
				</a>
			</div><!-- /header -->';		
			//////////////    Dropdown Menu Begins    //////////////		
			echo'	
			<div data-role="content">			
				<ul data-role="listview" data-filter="false" data-theme="c" class="ui-listview">			
					<li>
						<form action="browse.php?campus='.$campus.'" method="post">
							<div data-role="fieldcontain" class="ui-field-contain ui-body ui-br ui-hide-label">
								<label for="select-choice-min" class="select"></label>
								<select onchange="window.location=\'browse.php?campus=\' + this.value;" name="select-choice-min" id="select-choice-min" data-native-menu="true" data-mini="true" tabindex="-1">	
								<optgroup label="Select a Campus">
								<option value="'.$campus.'">'.$campus.'</option>'; //sets the placeholder for the school the user is currently browsing in
								$results = mysql_query("SELECT Name FROM Schools WHERE Name != '".$campus."' ORDER BY Name"); //gets all schools the user isn't currently browsing
								while($schools = mysql_fetch_array($results)){
									echo'<option value="'.$schools["Name"].'">'.$schools["Name"].'</option>'; 
								};// populates the drop down with all schools not including the one selected							
								echo'
								</optgroup>';
								echo'
								</select>
							</div>	
						</form>
					</li>
				</ul>				
				<!-- Used to correct formatting issue with search filter box position -->
				<ul data-role="listview" style="height:36px;"><li style="height:0px;">&nbsp;</li></ul>
				<!-- End -->
				<ul data-role="listview" data-filter="true" data-filter-placeholder="Search for a subject..." data-theme="d" data-dividertheme="d" class="ui-listview">';			
					//////////////    Dropdown Menu Ends (2 lines up)    //////////////				
					$sql = mysql_query("SELECT DISTINCT Subject FROM Courses WHERE School ='".$campus."' ORDER BY Subject");
					
					$subject_name = 'Subject';
					$lastDivider = '\0';    //The most recent letter used as a divider
					$firstLetter = '\0';     //The first letter of the subject pulled from the DB
					
					while ($rows = mysql_fetch_assoc($sql)){
						$firstLetter = substr($rows[$subject_name],0,1);
						if ($firstLetter != $lastDivider){
							echo '
							<li data-role="list-divider">
								' . substr($rows[$subject_name],0,1) . '
							</li>'; // Get first letter of subject to determine if new section divider needs to be added
							$lastDivider = substr($rows['Subject'],0,1);
						}
						echo '
						<li>
							<a href="courses.php?subject='.urlencode($rows['Subject']).'&school='.$campus.'"> 
								'.$rows['Subject'].'
							</a>
						</li>';
					};?>			
				</ul>		
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
