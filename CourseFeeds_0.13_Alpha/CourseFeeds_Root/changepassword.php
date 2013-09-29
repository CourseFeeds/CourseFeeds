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
		if (empty($_POST) === false){
			$required_fields = array(
				'current_password',
				'password',
				'password_again');
			foreach ($_POST as $key => $value){
				if (empty($value) && in_array($key, $required_fields) === true){
					$errors[] = 'All fields are required.';
					break 1;
				}
			}		
			if(md5($_POST['current_password']) === $user_data['Password']){
				if (trim($_POST['password']) !== trim($_POST['password_again'])){
					$errors[] = 'Your new passwords do not match';
				}else if(strlen($_POST['password']) < 6){
					$errors[] = 'Your password must be at least 6 characters';
				}
			}else{
			$errors[] = 'You current password is incorrect';
			}	
		}		
		if (isset($_GET['success']) && empty($_GET['success'])){
		?>
		<div data-role="dialog" id="success">
			<div data-role="content">
				<p> Your password has been changed! </p>
				<a href="index.php" data-role="button" data-transitio="flip">Continue</a>
			</div>
		</div>
		<?php
		}else{
			if(empty($_POST) === false && empty($errors) === true){
				change_password($Name, $_POST['password']);
				header('Location: changepassword.php?success');
			}else if(empty($errors) === false){
		?>
				<div data-role="dialog" id="error">
					<div data-role="header" data-theme="c">
						<h1>
							<span style="font-size:16pt;font-weight:bold;">
								Sign In
							</span>
						</h1>
					</div>
					<div data-role="content">
						<?php echo output_errors($errors); ?>
					</div> <!--Content-->
				</div> <!--Dialog-->	
			<div data-role="page" data-url="dialog.html" data-theme="c">
			</div>
			<?php 	exit();
			}
			?>		
			<div data-role="dialog" data-theme="b">		
				<div data-role="header" data-theme="c">
					<h1>
						<span style="font-size:16pt;font-weight:bold;">
							Change Password
						</span>
					</h1>
				</div> <!-- header -->			
				<div data-role="content" data-theme="b">
					<form action="changepassword.php" method="post">   
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="current_password">Current Password:</label>
							<input id="current_password" type="password" name="current_password" data-mini="true">
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="password">New Password:</label>
							<input id="password" type="password" name="password" placeholder="Must be at least 8 characters" data-mini="true">
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="password_again">Confirm New Password:</label>
							<input id="password_again" type="password" name="password_again" placeholder="Must match above password" data-mini="true">
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="changepassword"></label>
							<input id="changepassword" type="submit" data-mini="true" data-inline="false" value="Update"/>
						</div>
					</form>
				</div> <!--Content-->
			</div> <!-- /page -->	
		<?php 
		}
		?>
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
