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
		<div data-role="dialog">
			<div data-role="header" data-theme="c"> 
				<h1>
					<span style="font-size:16pt;font-weight:bold;">
						Newsletter
					</span>
				</h1> 
			</div> <!-- header -->
			<div data-role="content" data-theme="b">
				<?php
				if (isset($_REQUEST['email']))
				//if "email" is filled out, send email
				{
				//send email
				$emailThem = $_REQUEST["email"] ;
				$first = $_REQUEST["first"] ;
				$last = $_REQUEST["last"] ;
				$title = $_REQUEST["title"] ;
				$campus = $_REQUEST["campus"] ;
				$subjectThem = "CourseFeeds: Thanks for signing up for our newsletter!";
				$subjectUs = "CourseFeeds Bot: Newsletter Subscription Request";
				$messageThem = "Hi ". $first .",<br /> Please stay tuned for the latest on CourseFeeds, we have added you to our newsletter mailing list.<br /><br />To unsubscribe, please reply to this email with the phrase \"no more\".<br /><br />Sincerely, <br /><br />The CourseFeeds Development Team";
				$messageUs = "Name: ". $last .", ". $first ."<br />Email: ". $emailThem ."<br />Title: ". $title ."<br />Campus: ". $campus ."<br />Cory W will add this user to the newsletter mailing list or remove them if the user replies \"no more\".";
				// To send HTML mail, the Content-type header must be set
				$headersUs  = 'MIME-Version: 1.0' . "\r\n";
				$headersUs .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headersUs .= 'From:' . "no-reply@coursefeeds.com" . "\r\n";
				$headersThem  = 'MIME-Version: 1.0' . "\r\n";
				$headersThem .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headersThem .= 'From:' . "moderator@coursefeeds.com" . "\r\n";
				mail("cwoolf@coursefeeds.com", $subjectUs,
				$messageUs, $headersUs);
				mail($emailThem, $subjectThem,
				$messageThem, $headersThem);
				echo "
				Thank's ". $first ." for signing up for our newsletter, stay tuned!
				<a href=\"index.html\" rel=\"external\">Return to Home</a>";
				}else{
				//if "email" is not filled out, display the form
					echo "
					<form method=\"post\" action=\"email.php\">
						First Name: <input name=\"first\" type=\"text\" maxlength=\"40\" placeholder=\"John\">
						Last Name: <input name=\"last\" type=\"text\" maxlength=\"40\" placeholder=\"Smith\">
						Email: <input name=\"email\" type=\"text\" maxlength=\"40\" placeholder=\"jsmith@example.com\">
						<fieldset data-role=\"controlgroup\" data-theme=\"c\">
							<legend><b>Who are you?</b></legend>
							<input type=\"radio\" name=\"title\" id=\"radio-choice-1\" value=\"Student\" data-theme=\"c\" />
							<label for=\"radio-choice-1\">Student</label>
							<input type=\"radio\" name=\"title\" id=\"radio-choice-2\" value=\"Professor\" data-theme=\"c\" />
							<label for=\"radio-choice-2\">Professor</label>
							<input type=\"radio\" name=\"title\" id=\"radio-choice-3\" value=\"Administration\" data-theme=\"c\" />
							<label for=\"radio-choice-3\">University Administration</label>
							<input type=\"radio\" name=\"title\" id=\"radio-choice-4\" value=\"Other\" data-theme=\"c\" />
							<label for=\"radio-choice-4\">Other</label>
						</fieldset>
						<b>What academic institution are you affiliated with?</b><br />
						<input type=\"text\" name=\"campus\" data-theme=\"c\" maxlength=\"40\" placeholder=\"University of Michigan (Ann Arbor, MI)\" />
						<input type=\"submit\" value=\"Submit\" data-theme=\"b\">
					</form>";
				}
				?>
			</div><!-- /content -->
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
