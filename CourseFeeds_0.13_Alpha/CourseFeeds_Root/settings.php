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
			$required_fields = array('first_name');
			foreach($_POST as $key=>$value){
				if(empty($value) && in_array($key, $required_fields) === true){
					$errors[] = 'First name is required.';
					break 1;
				}
			}
			/* Email Validation
			if (empty($errors) === true)
			{
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) 
			{
			$errors[] = 'A valid email address is required';
			}
			else if (email_exists($_POST['email']) === true && $user_data['email'] !== $_POST['email'])
			{
			$errors[] = 'Sorry, the email \'' . $_POST['email'] . '\' is already in use';
			}
			}
			*/
		}
		if(isset($_GET['success']) && empty($_GET['success'])){
		 // do nothing
		}else{
			if(empty($_POST) === false && empty($errors) === true){
				$update_data = array(
				'FirstName'    	=> $_POST['first_name'],
				'LastName'     	=> $_POST['last_name'],
				'Campus'	   	=> $_POST['campus'],
				// 'Email'         => $_POST['email'],
				);
				update_user($update_data); ?>
				<div data-role="dialog" id="success">
					<div data-role="content">
						<p> You have updated your account successfully! </p>
						<a href="index.php" data-role="button" data-transitio="flip">Continue</a>
					</div>
				</div>
				<?php
			}else if (empty($errors) === false){ 
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
					</div><!--Content-->
				</div><!--Dialog-->
				<div data-role="page" data-url="dialog.html" data-theme="c">
				</div>
				<?php 
				exit();
			} ?>
			<div data-role="dialog" data-theme="c">
				<div data-role="header" data-theme="c"> 
					<h1>
						<span style="font-size:16pt;font-weight:bold;">
							Settings
						</span>
					</h1> 
				</div><!-- header -->
				<div data-role="content" data-theme="b">
					<form action="settings.php" data-rel="dialog" method="post">
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="first_name">First name:</label>
							<input id="first_name" name="first_name" data-mini="true" type="text" value="<?php echo $user_data['FirstName']; ?>" />
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="last_name">Last name:</label>
							<input id="last_name" name="last_name" data-mini="true" type="text" value="<?php echo $user_data['LastName']; ?>"/>
						</div>
						<!--<div data-role="fieldcontain" class="no-field-separator">
						<label for="email">Email:</label>
						<input id="email" name="email" data-mini="true" type="email" value="<?php // echo $user_data['Email']; ?>"/>
						</div>-->
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="campus">Campus:</label>
							<select data-native-menu="false" name="campus" id="campus" data-mini="true" data-theme="c">
								<?php
								$query = "SELECT Name FROM Schools ORDER BY NAME";
								$results = mysql_query($query);
								while($row = mysql_fetch_array($results)){
									$school = $row["Name"];
									echo '<option value="'.$school.'">'.$school.'</option>';
								}
								?>
							</select>
						</div>	
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="update"></label>
							<input id="update" type="submit" data-rel="dialog" data-mini="true" data-theme="b" value="Update" />
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="changeplink"></label>
							<a href="changepassword.php" data-rel="dialog" id="changeplink" data-mini="true" data-role="button" data-theme="c" data-icon="arrow-r">
								Change Your Password
							</a>
						</div>
					</form>
				</div> <!--Content-->
			</div> <!--page-->
		<?php
		}
		?> 
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
