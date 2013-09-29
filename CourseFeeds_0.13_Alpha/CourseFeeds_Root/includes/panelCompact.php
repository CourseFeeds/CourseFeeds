<!-- panel content goes here -->
<ul data-role="listview" data-theme="d" data-divider-theme="d" class="nav-search">
	<li id="menuSmall-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
		<a href="#" data-rel="close">
			<span style="margin-left:22px;">
				Close Menu
			</span>
		</a>
	</li>
	<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-d">Account Options</li>
	<?php
	if (logged_in() === true) { echo'
	<li>User: '.$user_data['Name'].'</li>
	<li class="active ui-btn-icon-left" id="logout-icon" data-icon="custom" data-icon-pos="left">
		<a href="logout.php">
			<span style="margin-left:22px;">
				Sign Out
			</span>
		</a>
	</li>
	<li id="settings-icon" class="ui-btn-icon-left" data-icon="custom" data-icon-pos="left">
		<a href="settings.php" data-rel="dialog" data-transition="pop">
			<span style="margin-left:22px;">
				Settings
			</span>
		</a>
	</li>';
	} else{ echo'
	<li class="active ui-btn-icon-left" id="login-icon" data-icon="custom" data-icon-pos="left">
		<a href="loginForm.php" data-rel="dialog" data-transition="pop">
			<span style="margin-left:22px;">
				Sign In
			</span>
		</a>
	</li>';
	}; ?>
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
	if (logged_in() === true) { 
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
				/* increase start by one to get past the paranthesis, end-start-1 is how many spots it reads */
				$subjectAcronym		= substr($subject, $start+1, $end - $start - 1);
			}	
			echo'
			<li>
					<a href="course.php?courseID='.$data["ID"].'&courseName='.urlencode($data["CourseTitle"]).'&subject='.urlencode($data["Subject"]).'" class="ui-link-inherit">											
							'. $data["CourseTitle"] .'								
					</a>	
			</li>';
		} 
		///////////////////////// End My Courses /////////////////////////		
	}
	?>
</ul><!-- panel content goes here -->
