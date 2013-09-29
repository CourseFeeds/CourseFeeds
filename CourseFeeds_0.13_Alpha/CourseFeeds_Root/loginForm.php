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
			$username = $_POST['username'];
			$password = $_POST['password'];
			//Check for the following conditions before attempting to log in user.
			if(empty($username) === true || empty($password) === true){
				$errors[] = 'You need to enter a username and password';
			}else if(user_exists($username) === false){
				$errors[] = 'User does not exist. Have you register?';
			}else if(user_active($username) === false){
				$errors[] = 'You haven\'t activated your account!';
			}else{
				if(strlen($password) > 32){
					$errors[] = 'Password is too long.';
				}
				//Everything seems good, so now we try to log in the user.
				$login = login($username, $password);
				//login function returns false if their was an error and returns username string if it passed. We check for this condtion below
				if($login === false){
					$errors[] = 'That username/password combination is incorrect';
				}else{ //Else, everything is successful, login user
					//For log me in cookie
					if(isset($_POST['rememberme'])){
						$expire = time() + 1209600; //20 days
						$cookie_pass = sha1(sha1(md5($password)) . sha1('lioLn1p#@l1pc0urs30xp'));
						setcookie('user', $username, $expire);
						setcookie('pass', $cookie_pass, $expire);
					}
					$_SESSION['Name'] = $login;     
					header('Location: indexRefresh.html');
					exit();
				}
			}  
		}else{ 
			//$errors[] = 'No data received';
		}//IF there was errors, we have to print out what went wrong.
		if(empty($errors) === false){
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
			<!--This is needed to prevent multidialog bug-->
			<div data-role="page" data-url="dialog.html" data-theme="c">
			</div><!-- /page -->
		<?php die();
		}
		?>
		<div data-role="dialog" data-theme="c">
			<div data-role="header" data-theme="c"> 
				<h1>
					<span style="font-size:16pt;font-weight:bold;">
						CourseFeeds
					</span>
				</h1> 
			</div><!-- header -->
			<div data-role="content" data-theme="b">
				<form action="loginForm.php" method="post">
					<div data-role="fieldcontain" class="ui-hide-label no-field-separator">
						<label for="username">Username</label>
						<input type="text" id="username" name="username" placeholder="Username" data-mini="true" data-corners="false"/>
					</div>
					<div data-role="fieldcontain" class="ui-hide-label no-field-separator">
						<label for="password">Password</label>
						<input type="password" id="password" name="password" placeholder="Password" data-mini="true"/>
					</div>
					<!-- Fix needed
					<div data-role="fieldcontain" class="ui-hide-label no-field-separator">
					<label><input type="checkbox" name="rememberme" id="rememberme" data-mini="true" />Stay signed in</label>
					</div>
					-->
					<div class="ui-grid-a">
						<div class="ui-block-a"> 
							<a href="register.php" data-role="button" data-mini="true" data-rel="dialog" data-theme="c">
								Register
							</a> 
						</div>
						<div class="ui-block-b"> 
							<input type="submit" value="Sign In" data-mini="true" data-theme="b"/> 
						</div>
					</div><!-- /Grid -->
					<p>Forgot your 
						<a href="recover.php?mode=username" data-role="button" data-mini="true" data-inline="true" data-rel="dialog" data-theme="c">
							Username
						</a> or 
						<a href="recover.php?mode=password" data-role="button" data-mini="true" data-inline="true" data-rel="dialog" data-theme="c">
							Password
						</a>?
					</p>
				</form>
			</div> <!--/Content-->
		</div> <!--/page-->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
