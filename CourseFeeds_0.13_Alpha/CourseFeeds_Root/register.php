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
		if(empty($_POST) === false){
			$required_fields = array('username','password','password_again','first_name','email');
			foreach($_POST as $key=>$value){
				if(empty($value) && in_array($key, $required_fields) === true){
					$errors[] = 'Fields marked with an asterisk are required';
					break 1;
				}
			}
			//Checks the form fills... 
			if(empty($errors) === true){
				if(user_exists($_POST['username']) === true){
					$errors[] = 'Sorry, the username \'' . $_POST['username'] . '\' is already taken.';
				}
				if(preg_match("/\\s/", $_POST['username']) == true){
					$errors[] = 'Your username can\'t contain spaces.';
				}
				if(strlen($_POST['password']) < 6){
					$errors[] = 'Your password must be at least 6 characters';
				}
				if($_POST['password'] !== $_POST['password_again']){
					$errors[] = 'Your passwords do noth match';
				}
				/*	REQUIRE .edu EMAIL ADDRESS
				if (preg_match("/.edu/i", trim($_POST['email'])) == false) {
				$errors[] = 'You must register with a .edu email address.';
				}
				*/
				if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
					$errors[] = 'A valid email address is required';
				}
				if(email_exists($_POST['email']) === true){
					$errors[] = 'Sorry, the email \'' . $_POST['email'] . '\' is already in use';
				}
			}
		}
		if(isset($_GET['success']) && empty($_GET['success'])){
			// do nothing
		}else{
			//puts into database
			if(empty($_POST) === false && empty($errors) === true){
				$register_data = array(
				'Name' => $_POST['username'],
				'Password' => $_POST['password'],
				'FirstName' => $_POST['first_name'],
				'LastName' => $_POST['last_name'],
				'Campus' => $_POST['campus'],
				'Email' => $_POST['email'],
				'EmailCode' => md5($_POST['username'] + microtime()),
				'CreatedDate' => current_time(),
				'IsProfessor' => $_POST['professor']
				);
				register_user($register_data);
				?>
				<div data-role="dialog" id="error">
					<div data-role="content">
						<p>
							You have registered successfully!
						</p>
						<a href="index.php" data-role="button" data-transition="flip">Continue</a>
					</div><!--Content-->
				</div><!--Page-->
			<?php
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
					</div> <!--Content-->
				</div> <!--Dialog-->
				<!--This is needed to prevent multidialog bug-->
				<div data-role="page" data-url="dialog.html" data-theme="c">
				</div><!-- /page -->
				<?php
				exit();
			}
			?>
			<div data-role="dialog">
				<div data-role="header" data-theme="c"> 
					<h1>
						<span style="font-size:16pt;font-weight:bold;">
							Create Account
						</span>
					</h1> 
				</div><!-- header -->
				<div data-role="content" data-theme="b">
					<form action="register.php" method="post">
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="username">Username:*</label>
							<input id="username" name="username" data-mini="true" placeholder="Must be at least 6 characters" type="text"/>
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="password">Password:*</label>
							<input id="password" name="password" data-mini="true" placeholder="Must be at least 8 characters" type="password"/>
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="password_again">Confirm Password:*</label>
							<input id="password_again" name="password_again" data-mini="true" placeholder="Must match password above" type="password"/>
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="first_name">First name:*</label>
							<input id="first_name" name="first_name" data-mini="true" placeholder="John" type="text"/>
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="last_name">Last name:*</label>
							<input id="last_name" name="last_name" data-mini="true" placeholder="Smith" type="text"/>
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="email">Email:*</label>
							<input id="email" name="email" data-mini="true" placeholder="johnsmith@example.com" type="email"/>
						</div>     
						<div data-role="fieldcontain" class="no-field-separator" data-theme="c">
							<label for="campus">Campus:</label>
							<select data-native-menu="false" name="campus" id="campus" data-theme="c">
								<?php
								$sql = mysql_query("SELECT Name FROM Schools ORDER BY Name ASC");
								$schol_name = 'Name';			
								while($rows = mysql_fetch_assoc($sql)){
									echo '<option value="' . $rows[$schol_name] . '">' . $rows[$schol_name] . '</option>';
								}
								?>
							</select>
						</div>
						<div data-role="fieldcontain" class="ui-hide-label no-field-separator">
							<label>
								<input type="checkbox" name="professor" id="professor" data-mini="true" data-theme="c" />
								I'm a professor (Verification Required)
							</label>
						</div>
						<div data-role="fieldcontain" class="no-field-separator">
							<label for="register"></label>
							<input id="register" type="submit" value="Register" data-mini="true" data-inline="true"/>
						</div>
					</form>
				</div> <!--CONTENT-->
			</div> <!-- /page-->
		<?php 
		}
		?>
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
