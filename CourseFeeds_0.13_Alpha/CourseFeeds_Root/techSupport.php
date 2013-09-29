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
		$attempt = htmlspecialchars($_GET["attempt"]);//gets attempt status
		$related = $_GET["select-choice-question"]; //gets the type of question
		$question = $_GET["textarea"]; //gets the question
		$first = $_GET["first"]; //gets the first name
		$last = $_GET["last"]; //gets the last name
		$email = $_GET["email"]; //gets the email address
		if($attempt == 1 && (empty($first) || empty($last) || empty($email) || empty($question) || empty($related))){
			echo'
			<div data-role="dialog" data-theme="b">
				<div data-role="header" data-theme="c"> 
					<h1>
						<span style="font-size:16pt;font-weight:bold;">
							Technical Support
						</span>
					</h1> 
				</div><!-- header -->
				<div data-role="content" data-theme="b">
					<ul data-role="listview" data-theme="c" class="ui-listview">
						<li>
							<span style="color:red;">
								Error: Please fill in all fields before submitting!
							</span>
						</li>
					</ul>
					<div data-role="collapsible" data-theme="c">
						<h3>
							Frequently Asked Questions
						</h3>
						<ul data-role="listview" data-prevent-focus-zoom="true" data-inset="true" data-theme="c">
							<li>
							FAQ Section Coming Soon!
							</li>
						</ul>
					</div>	
					<div class="ui-grid-a" style="margin-bottom:15px;">
						<div class="ui-block-a">
							<a href="quickstart.php" target="_blank" data-role="button" data-theme="c" data-mini="true" data-ajax="false" data-icon="custom" id="quickstart2-icon">
								Quick-Start Guide
							</a>
						</div>
					<div class="ui-block-b">
						<a href="email.php" data-role="button" data-rel="dialog" data-transition="none" data-theme="c" data-mini="true" data-icon="custom" id="newsletter-icon">
							Newsletter
						</a>
					</div>
				</div>			
				<h4>
					Please select the category that best matches your question.<br /><br />
					We strive to respond to all questions within 24 hours. 
				</h4>
				<form action="techSupport.php?attempt=1" method="get">
				<ul data-role="listview" data-prevent-focus-zoom="true" data-inset="true" data-theme="c">
					<li>
						<div data-role="fieldcontain">
							<fieldset data-role="controlgroup">
								<legend><h2>Category: </h2></legend>
								<label for="select-choice-question">Category: </label>
								<select name="select-choice-question" id="select-choice-question" data-theme="c">
									<option>Choose one...</option>				
									<option value="Functionality">App Functionality</option>
									<option value="Campus">Campus Requests</option>
									<option value="Professor">Professors</option>
									<option value="Business">Business</option>
									<option value="Press">Press</option>
									<option value="DMCA">DMCA Take Down Requests</option>	
									<option value="Other">Something Else!</option>
								</select>	
							</fieldset>
						</div>
					</li>
					<li>
						<div data-role="fieldcontain">
							<label for="textarea">
								<h2>
									Question: 
								</h2>
							</label>
							<textarea rows="30" cols="30" name="textarea" id="textarea" style="height:200px;">'.$question.'</textarea>
						</div>
					</li>
					<li>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="first">First name:</label>
							<input id="first" name="first" data-mini="true" placeholder="John" type="text"/>
						</div>
					</li>
					<li>	
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="last">Last name:</label>
							<input id="last" name="last" data-mini="true" placeholder="Smith" type="text"/>
						</div>
					</li>
					<li>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="email">Email:</label>
							<input id="email" name="email" data-mini="true" type="email" ';
							if(logged_in() === true){
								echo' value="'.$user_data["Email"].'" >';
							}else{
								echo' placeholder="johnsmith@example.com" >';
							}
							echo'
						</div>
					</li>
					<li>
						<button type="submit" data-theme="b" name="submit" value="name" class="ui-btn-hidden" aria-disabled="false">
							Submit Question
						</button>
					</li>
				</ul>
			</form>';
		}else if($attempt == '1'){
			echo'
			<div data-role="dialog" data-theme="b">
				<div data-role="header" data-theme="c"> 
					<h1>
						<span style="font-size:16pt;font-weight:bold;">
							Technical Support
						</span>
					</h1> 
				</div> <!-- header -->
				<div data-role="content" data-theme="b">
					<ul data-role="listview" data-theme="c" class="ui-listview">
						<br />
						<li>
							The CourseFeeds Tech Support Team has been notified, keep an eye out for a response shortly!
						</li>
						<br />
						<a href="index.php" data-role="button" data-theme="b" style="margin:10px;">Close</a>
					</ul>
				';
				//send email to moderators with violation information and confirm removal link
				$from = "no-reply@coursefeeds.com";
				$subject = 'Question: '. $related .', Date/Time: '.date('m-d-Y H:i:s');
				//email message
				$message =
				"<div style=\"font-size: 13pt;\">Question Category: ". $related ."
				<br /><br />
				<br />Date/Time Submitted: " .date('m-d-Y H:i:s'). "
				<br />Name: " .$last. ", " .$first. " 
				<br /><br />
				<br />Question: " . $question . "
				<br />Reply to Email Address: " . $email . "
				</div>";
				$to  = 'cwoolf@coursefeeds.com';
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From:' . $from . "\r\n";
				mail( $to, $subject,
				$message, $headers);
				}else{
				echo'
				<div data-role="page" data-theme="b">
					<div data-role="header" data-theme="c"> 
						<h1>
							<span style="font-size:16pt;font-weight:bold;">
								Technical Support
							</span>
						</h1> 
					</div><!-- header -->
					<div data-role="content" data-theme="b">
						<div data-role="collapsible" data-theme="c">
							<h3>Frequently Asked Questions</h3>
							<ul data-role="listview" data-prevent-focus-zoom="true" data-inset="true" data-theme="c">
								<li>
									FAQ Section Coming Soon!
								</li>
							</ul>
						</div>	
						<div class="ui-grid-a" style="margin-bottom:15px;">
							<div class="ui-block-a">
								<a href="quickstart.php" target="_blank" data-role="button" data-theme="c" data-mini="true" data-ajax="false" data-icon="custom" id="quickstart2-icon">
									Quick-Start Guide
								</a>
							</div>
							<div class="ui-block-b">
								<a href="email.php" data-role="button" data-rel="dialog" data-transition="none" data-theme="c" data-mini="true" data-icon="custom" id="newsletter-icon">
									Newsletter
								</a>
							</div>
						</div>			
						<h4>
							Please select the category that best matches your question.<br /><br />
							We strive to respond to all questions within 24 hours. 
						</h4>
						<form action="techSupport.php?attempt=1" method="get">
							<ul data-role="listview" data-prevent-focus-zoom="true" data-inset="true" data-theme="c">
								<li>
									<div data-role="fieldcontain">
										<fieldset data-role="controlgroup">
											<legend><h2>Category:</h2></legend>
											<label for="select-choice-question">Category: </label>
											<select name="select-choice-question" id="select-choice-question" data-theme="c">
											  <option>Choose one...</option>					
											  <option value="Functionality">App Functionality</option>
											  <option value="Campus">Campus Requests</option>
											  <option value="Professor">Professors</option>
											  <option value="Business">Business</option>
											  <option value="Press">Press</option>
											  <option value="DMCA">DMCA Take Down Requests</option>	
											  <option value="Other">Something Else!</option>
											</select>	
										</fieldset>
									</div>
								</li>
								<li>
									<div data-role="fieldcontain">
										<label for="textarea"><h2>Question: </h2></label>
										<textarea rows="30" cols="30" name="textarea" id="textarea" style="height:200px;">'.$question.'</textarea>
									</div>
								</li>
								<li>
									<div data-role="fieldcontain" class="no-field-separator">
										<label for="first">First name:</label>
										<input id="first" name="first" data-mini="true" placeholder="John" type="text"/>
									</div>
								</li>
								<li>	
									<div data-role="fieldcontain" class="no-field-separator">
										<label for="last">Last name:</label>
										<input id="last" name="last" data-mini="true" placeholder="Smith" type="text"/>
									</div>
								</li>
								<li>
									<div data-role="fieldcontain" class="no-field-separator">
										<label for="email">Email:</label>
										<input id="email" name="email" data-mini="true" type="email" ';
										if(logged_in() === true){
											echo' value="'.$user_data["Email"].'" >';
										}else{
											echo' placeholder="johnsmith@example.com" >';
										}
										echo'
									</div>
								</li>
								<li>
									<button type="submit" data-theme="b" name="submit" value="name" class="ui-btn-hidden" aria-disabled="false">
										Submit Question
									</button>
								</li>
							</ul>
					</form>';}
					?>		
		</div> <!-- content-->
		</div><!-- /page -->
	</body>
<?php include 'includes/analytics.php'; ?>
</html>
