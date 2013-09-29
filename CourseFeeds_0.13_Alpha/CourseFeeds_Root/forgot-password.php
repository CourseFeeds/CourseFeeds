<?php
include 'core/init.php';
$version = "0.13 Alpha";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>
  		<?php include 'includes/head.php'; ?>
	</head>
	<body>
			<?php
			if((isset($_GET['email'], $_GET['lost_password_code']) === true) && (password_recovery($_GET['email'], $_GET['lost_password_code']) === true)){   
				$url = "forgot-password.php?email=" . $_GET['email'] . "&lost_password_code=" . $_GET['lost_password_code'] . "";
			if(empty($_POST) === false){
				$required_fields = array('password', 'password_again');
			foreach ($_POST as $key => $value){
				if(empty($value) && in_array($key, $required_fields) === true){
					$errors[] = 'Fields marked with an asterisk are required';
					break 1;
				}
			}
			if(trim($_POST['password']) !== trim($_POST['password_again'])){
				$errors[] = 'Your new passwords do not match';
			}else{
				if(strlen($_POST['password']) < 6){
					$errors[] = 'Your password must be at least 6 characters';
				}
			}
			if(empty($_POST) === false && empty($errors) === true){
				change_password(user_name_from_email($_GET['email']), $_POST['password']);
				header('Location: forgot-password.php?success');
			}else if(empty($errors) === false){
			?>
				  <div data-role="dialog" id="error">
					<div data-role="header" data-theme="c">
						<h1>
							<span style="font-size:16pt;font-weight:bold;">
								Create Account
							</span>
						</h1>
					</div>
					<div data-role="content">
						<?php echo output_errors($errors); ?>
					</div><!--Content-->
				</div><!--Dialog-->
				<!--This is needed to prevent multidialog bug-->
				<div data-role="page" data-url="dialog.html" data-theme="c"></div><!-- /page -->
				<?php
				exit();   
			}?>
			  <div data-role="dialog">
				<div data-role="header" data-theme="c">
				  <h1><span style="font-size:16pt;font-weight:bold;">Password Recovery</span></h1>
				</div><!-- header -->
				<div data-role="content">
				  <ul data-role="listview" data-theme="c" data-dividertheme="b" class="ui-listview ui-corner-all ui-shadow">
					<li>
					  <form action="%3C?php%20echo%20$url%20?%3E" method="post">
						<div data-role="fieldcontain" class="no-field-separator">
						  <label for="password">New Password:</label> <input id="password" type="password" name="password" data-mini="true">
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
						  <label for="password_again">Confirm New Password:</label> <input id="password_again" type="password" name="password_again" data-mini="true">
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
						  <input id="changepassword" type="submit" data-mini="true" data-inline="false" value="Update">
						</div>
					  </form>
					</li>
				  </ul>
				</div><!--Content-->
			  </div><!-- /page -->
		  <?php
			} else if ((isset($_GET['email'], $_GET['lost_password_code']) === true) && (password_recovery($_GET['email'], $_GET['lost_password_code']) === false)){
				if (email_exists($_GET['email']) === false){
					$errors[] = 'Coud not find email address.';
				}else{
					$errors[] = 'We had problems recovering your account';
				} 
				if(empty($errors) === false){
			?>
		  	<div data-role="dialog" id="error">
				<div data-role="content">
			  		<?php echo output_errors($errors); ?> <a href="index.php" data-role="button" data-transition="flip">Continue</a>
				</div><!--Content-->
		  	</div><!--Dialog-->
		  	<?php
				}
			}else if (isset($_GET['success']) && empty($_GET['success'])){
			?>
		 	<div data-role="dialog" id="error">
				<div data-role="content">
			  		<?php echo 'You have successfully changed your password.' ?> 
			  			<a href="index.php" data-role="button" data-transition="flip">
			  				Continue
			  			</a>
				</div><!--Content-->
		  	</div><!--Dialog-->
		  	<?php
			}
			include 'includes/analytics.php'; ?>
	</body>
</html>
