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
		<!-- Start of first page -->
		<div data-role="page" id="requirements">
			<div data-role="header" data-position="fixed" data-theme="c">
				<a href="JavaScript:window.close()" class="ui-btn-left" data-icon="delete">
					Close
				</a>
				<h1>
					Requirements
				</h1>
			</div><!-- /header -->
			<div data-role="content">	
				<img src="images/quickstart/quickstart.png" style="text-align: center; margin: auto 0 !important;padding:0 !important;" />
				<p>1. <b>Anyone</b> can register with CourseFeeds. 	
				<p>2. Only registered users may submit links, post comments, vote, access Favorites, and report violations.</p>	
				<p>3. The following desktop browsers are officially supported (as of 07/13/2013) by CourseFeeds:</p>
				<ul>
					<li><b>Chrome:</b> version 23.0.1271.97 or newer</li>
					<li><b>Firefox:</b> version 17.01 or newer</li>
					<li><b>Internet Explorer:</b> version 10.0.1 or newer</li>
					<li><b>Safari:</b> version 6.0.2 or newer</li>
				</ul>
				<p>
					<a href="http://jquerymobile.com/gbs/" target="_blank" data-ajax="false" data-role="button" data-icon="alert" data-mini="true">
						Mobile Device Compatibility
					</a>
				</p>
				</div><!-- /content -->
				<div data-role="footer" data-position="fixed" data-theme="c" style="opacity:0.95;">
					<div style="text-align: center;">
						<span style="font-size:40pt;font-weight:normal;">
							<b>&middot;</b>&middot;&middot;&middot;&middot;&middot;&middot;
						</span>
					</div>
					<div data-role="controlgroup" data-type="horizontal" class="ui-corner-all ui-controlgroup 
					ui-controlgroup-horizontal" style="text-align: center;">
						<div class="ui-controlgroup-controls">
							<a href="#register" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="c" 
							data-inline="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" title="Next" 
							class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
								<span class="ui-btn-inner">
									<span class="ui-btn-text">
										Next
									</span>
									<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">
										&nbsp;
									</span>
								</span>
							</a>
						</div>
					</div>
				</div><!-- /footer -->
			</div><!-- /page -->
			<!-- Start of second page -->
			<div data-role="page" id="register">
				<div data-role="header" data-position="fixed" data-theme="c">
					<a href="JavaScript:window.close()" class="ui-btn-left" data-icon="delete">
						Close
					</a>
					<h1>
						Register
					</h1>
				</div><!-- /header -->
				<div data-role="content">	
					<img src="images/quickstart/quickstart_register.png" width="95%" style="margin-left:5px;" />
					<p>1. Tap or click on the <span style="color:red;">Register</span> button found on the Home page</p>		
					<p>2. Fill out the registration form, be sure to use your .edu email address. Select your default campus, this can be changed later.</p>
					<p>3. Submit the form and check your .edu email for a message from CourseFeeds, tap or click the verification link in the message.</p>	
				</div><!-- /content -->
				<div data-role="footer" data-position="fixed" data-theme="c" style="opacity:0.95;">
					<div data-theme="c" style="text-align: center;"><span style="font-size:40pt;font-weight:normal;">
						&middot;<b>&middot;</b>&middot;&middot;&middot;&middot;&middot;
					</span>
				</div>
				<div data-role="controlgroup" data-type="horizontal" class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal" 
				style="text-align: center;">
					<div class="ui-controlgroup-controls">
						<a href="#requirements" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="c" 
						data-inline="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" title="Previous" 
						class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Previous
								</span>
								<span class="ui-icon ui-icon-arrow-l ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
						<a href="#navigation" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="c" 
						data-inline="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" title="Next" 
						class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Next
								</span>
								<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
					</div>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<!-- Start of third page -->
		<div data-role="page" id="navigation">
			<div data-role="header" data-position="fixed" data-theme="c">
				<a href="JavaScript:window.close()" class="ui-btn-left" data-icon="delete">
					Close
				</a>
				<h1>
					Navigation
				</h1>
			</div><!-- /header -->
			<div data-role="content">	
				<img src="images/quickstart/quickstart_navigation.png" width="95%" style="margin-left:5px;" />
				<p>1. To navigate through the primary sections of CourseFeeds, tap or click on any of the four buttons in the footer 
				<span style="color:red;">navbar</span> found at the bottom of the screen.</p>		
				<p>2. To navigate to secondary sections of CourseFeeds, tap or click on the <span style="color:green;">Menu</span> 
				button in the header, then tap or click any of the buttons found in the slide out menu.</p>
				<p>3. In the slide out menu, tap or click on the <span style="color:orange;">Sign In</span> button, then sign in. 
				Note that the Sign Out button will replace the Sign In button in the slide out menu (once signed in).</p>	
				</div><!-- /content -->
				<div data-role="footer" data-position="fixed" data-theme="c" style="opacity:0.95;">
					<div data-theme="c" style="text-align: center;"><span style="font-size:40pt;font-weight:normal;">
						&middot;&middot;<b>&middot;</b>&middot;&middot;&middot;&middot;
					</span>
				</div>
				<div data-role="controlgroup" data-type="horizontal" class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal" 
				style="text-align: center;">
					<div class="ui-controlgroup-controls">
						<a href="#register" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="c" data-inline="true" 
						data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" title="Previous" 
						class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									My button
								</span>
								<span class="ui-icon ui-icon-arrow-l ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
						<a href="#browse" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="c" data-inline="true" 
						data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" title="Next" 
						class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									My button
								</span>
								<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
					</div>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<!-- Start of fourth page -->
		<div data-role="page" id="browse">
			<div data-role="header" data-position="fixed" data-theme="c">
				<a href="JavaScript:window.close()" class="ui-btn-left" data-icon="delete">
					Close
				</a>
				<h1>
					Browse
				</h1>
			</div><!-- /header -->
			<div data-role="content">	
				<img src="images/quickstart/quickstart_browse.png" width="95%" style="margin-left:5px;" />
				<p>1. <b>Subjects:</b> To find your courses, tap or click the <span style="color:red;">Browse</span> 
				button in the footer navbar. When signed in, your default campus chosen during the registration process is 
				automatically selected, feel free to browse other campuses through the drop-down menu as well. Simply scroll 
				or use the search filter to find the subject of one of your courses. Once found, tap or click on the subject.</p>		
				<p>2. <b>Courses:</b> The <span style="color:#0099ff;">General Links</span> list contains resources that are 
				helpful for many different courses within the chosen subject. The <span style="color:#00a651;">course list</span> 
				contains all of the courses offered for the current semester for the chosen subject. Tap or click on one of your courses.</p>
				<p>3. <b>Course:</b> The links in the <span style="color:orange;">lists</span> are sorted based on total 
				votes or submission date. To subscribe to a course, tap or click on the <span style="color:#f06eaa;">
				Add to My Courses</span> button. You will be added to the <span style="color:blue;">Students</span>
				page for the course, where you can view others subscribed to the same course. To reveal previous 
				semesters, tap or click on the <span style="color:purple;">Semesters Offered</span> button. 
				You can vote up or down a link from the Course page for convenience by tapping or clicking on 
				the green or red buttons within each link button. In order to view a resource (link), tap or click on one of the link 
				buttons in the <span style="color:orange;">lists</span>. You'll be taken to the Link Details page.</p>	
			</div><!-- /content -->
			<div data-role="footer" data-position="fixed" data-theme="c" style="opacity:0.95;">
				<div data-theme="c" style="text-align: center;">
					<span style="font-size:40pt;font-weight:normal;">
						&middot;&middot;&middot;<b>&middot;</b>&middot;&middot;&middot;
					</span>
				</div>
				<div data-role="controlgroup" data-type="horizontal" class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal"
				style="text-align: center;">
					<div class="ui-controlgroup-controls">
						<a href="#navigation" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="c" data-inline="true" 
						data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" title="Previous" class="ui-btn 
						ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Previous
								</span>
								<span class="ui-icon ui-icon-arrow-l ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
						<a href="#linkdetails" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="c" data-inline="true" 
						data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" title="Next" class="ui-btn 
						ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Next
								</span>
								<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
					</div>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<!-- Start of fifth page -->
		<div data-role="page" id="linkdetails">
			<div data-role="header" data-position="fixed" data-theme="c">
				<a href="JavaScript:window.close()" class="ui-btn-left" data-icon="delete">
					Close
				</a>
				<h1>
					Link Details
				</h1>
			</div><!-- /header -->
			<div data-role="content">	
				<img src="images/quickstart/quickstart_linkdetails.png" width="95%" style="margin-left:5px;" />
				<p>1. <b>View Options: </b>To view the link in a new window, tap or click on the <span style="color:red;">View</span> button. 
				If the link is to an embeddable video (YouTube or Vimeo), the video will be available for 
				<span style="color:red;">viewing directly</span> on the Link Details page. If the video is embedded, there will also be a 
				<span style="color:#19ad62;">Beam</span> button present, which opens a new window that is optimized for use with 
				Twonky Beam iOS, Android, Mac, and PC software. Twonky Beam allows users to wirelessly 
				stream a video from a mobile device to a supported smart-TV, Apple TV, Roku, Xbox 360, 
				or other home theater playback device. For more information on Twonky Beam, please visit 
				the Beam page that can be accessed from any Link Details page that has an embedded video.</p>		
				<p>2. <b>Information and Description: </b>A <span style="color:#aba000;">description</span> of the link can be found within 
				the Link Details page, 
				as well as <span style="color:#aba000;">information</span> such as the title, media-type, number of views (through CourseFeeds), 
				course name, and 
				the username of the submitter.</p>
				<p>3. <b>Starring and Reporting: </b>When signed in, users have the option to <span style="color:#0000ff;">Star</span> a link, 
				which stores a bookmark to the link within the Favorites page (accessible from the footer navbar). 
				Tapping or clicking on the <span style="color:#0000ff;">Star</span> button will Star the link, links submitted by the 
				signed in user are automatically added to their Favorites page for convenience. If a link violates the CourseFeeds Terms of Service,
				users are encouraged to report the link by tapping or clicking the <span style="color:orange;">Report</span> button. If the signed
				in user submitted the link, a <span style="color:orange;">Delete</span> button will replace the <span style="color:orange;">Report</span>
				button (which is the case in the image above).</p>	
				<p>4. <b>Voting and Commenting: </b>It's sometimes necessary to scroll downwards on the Link Details page to find the vote 
				buttons and <span style="color:#003471;">comment-section accordion</span> button. Tapping or clicking on either the 
				<span style="color:#005826;">Up-Vote</span> or <span style="color:#9e0b0f;">Down-Vote</span> buttons will share your 
				opinion of the quality of the link with other users. The commenting section allows users to add their own comment(s), 
				as well as report or delete comments (similar to reporting or deleting a link).</p>
			</div><!-- /content -->
			<div data-role="footer" data-position="fixed" data-theme="c" style="opacity:0.95;">
				<div data-theme="c" style="text-align: center;">
					<span style="font-size:40pt;font-weight:normal;">
						&middot;&middot;&middot;&middot;<b>&middot;</b>&middot;&middot;
					</span>
				</div>
				<div data-role="controlgroup" data-type="horizontal" class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal" style="text-align: center;">
					<div class="ui-controlgroup-controls">
						<a href="#browse" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="c" data-inline="true" data-corners="true" 
						data-shadow="true" data-iconshadow="true" data-wrapperels="span" title="Previous" class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Previous
								</span>
								<span class="ui-icon ui-icon-arrow-l ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
						<a href="#favorites" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="c" data-inline="true" 
						data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" title="Next" class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Next
								</span>
								<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
					</div>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<!-- Start of sixth page -->
		<div data-role="page" id="favorites">
			<div data-role="header" data-position="fixed" data-theme="c">
				<a href="JavaScript:window.close()" class="ui-btn-left" data-icon="delete">
					Close
				</a>
				<h1>
					Favorites
				</h1>
			</div><!-- /header -->
			<div data-role="content">	
				<img src="images/quickstart/quickstart_favorites.png" width="95%" style="margin-left:5px;" />
				<p>1. <b>Add to My Courses: </b>To subscribe to a course, simply tap or click on the 
				<span style="color:#00ff00;">Add to My Courses</span> button that can be found on each course's Course page.</p>
				<p>2. <b>Storage Selection: </b>To select the storage location, simply tap or click on an <span style="color:#003471;">empty storage</span> button or tap/click on an 
				existing course subscription button to overwrite it with the new course. Then scroll downwards and tap/click the submission button at the bottom of the page.
				<p>3. <b>View Starred Link: </b>To view a link on the Favorites page, tap or click on the <span style="color:red;">Favorites</span> 
				button in the footer navbar. When signed in, you will be able to access your Starred links based on the semester that they were submitted. 
				Tap or click on any of the <span style="color:#aba000;">links</span> in the list(s).</p>		
				<p>4. <b>Remove Starred Link: </b>To remove (un-star) a link from the Favorites page, simply tap or click on the 
				<span style="color:#0000ff;">X icon</span> that corresponds to the link you wish to remove.</p>
				<p>5. <b>Export Semester Starred Links: </b>To export all starred links for a semester, tap or click the <span style="color:#4b8866;">Export</span> button in the semester divider bar. You will receive an email (for .edu) containing the starred links for the chosen semester. (FEATURE COMING SOON!)</p> 	
			</div><!-- /content -->
			<div data-role="footer" data-position="fixed" data-theme="c" style="opacity:0.95;">
				<div data-theme="c" style="text-align: center;">
					<span style="font-size:40pt;font-weight:normal;">
						&middot;&middot;&middot;&middot;&middot;<b>&middot;</b>&middot;
					</span>
				</div>
				<div data-role="controlgroup" data-type="horizontal" class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal" 
				style="text-align: center;">
					<div class="ui-controlgroup-controls">
						<a href="#linkdetails" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="c" 
						data-inline="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" 
						title="Previous" class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Previous
								</span>
								<span class="ui-icon ui-icon-arrow-l ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
						<a href="#addlink" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="c" 
						data-inline="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" 
						title="Next" class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Next
								</span>
								<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
					</div>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<!-- Start of seventh page -->
		<div data-role="page" id="addlink">
			<div data-role="header" data-position="fixed" data-theme="c">
				<a href="JavaScript:window.close()" class="ui-btn-left" data-icon="delete">
					Close
				</a>
				<h1>
					Add Link
				</h1>
			</div><!-- /header -->
			<div data-role="content">	
				<img src="images/quickstart/quickstart_addlink.png" width="95%" style="margin-left:5px;" />
				<p>1. <b>Find Link: </b>After finding a helpful webpage, YouTube Video, PDF, or any other content that has a 
				URL (link) associated with itself, <span style="color:#00ff00;">copy the URL</span> from your web browser.</p>		
				<p>2. <b>Add Link Subject: </b>To add the URL you just copied to the computer's clipboard, simply tap or click on the 
				<span style="color:red;">Add Link</span> button, which can be found in the footer navbar. Then <span style="color:blue;">select the course</span> under My Courses, if you are subscribed to the course. Otherwise browse and tap/click on the desired subject and then tap/click on the desired course.</p>
				<p>3. <b>Add Link: </b>Paste the URL from the computer's clipboard into the URL text-box. Then give the link a title, description, tags (keywords related to content), and define the media-type through the drop-down menu. Lastly, tap or click the <span style="color:#4b8866;">Add Link</span> button at the bottom of the page.</p>
			</div><!-- /content -->
			<div data-role="footer" data-position="fixed" data-theme="c" style="opacity:0.95;">
				<div data-theme="c" style="text-align: center;">
					<span style="font-size:40pt;font-weight:normal;">
						&middot;&middot;&middot;&middot;&middot;&middot;<b>&middot;</b>
					</span>
				</div>
				<div data-role="controlgroup" data-type="horizontal" class="ui-corner-all ui-controlgroup ui-controlgroup-horizontal" 
				style="text-align: center;">
					<div class="ui-controlgroup-controls">
						<a href="#favorites" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="c" 
						data-inline="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" 
						title="Previous" class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Previous
								</span>
								<span class="ui-icon ui-icon-arrow-l ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
						<a href="JavaScript:window.close()" data-role="button" data-icon="delete" data-iconpos="notext" data-theme="c" 
						data-inline="true" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" 
						title="Next" class="ui-btn ui-btn-inline ui-btn-icon-notext ui-btn-up-c">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Close
								</span>
								<span class="ui-icon ui-icon-delete ui-icon-shadow">
									&nbsp;
								</span>
							</span>
						</a>
					</div>
				</div>
			</div><!-- /footer -->
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
