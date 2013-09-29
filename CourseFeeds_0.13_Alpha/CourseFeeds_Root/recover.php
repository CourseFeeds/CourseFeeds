<?php
ob_start();
include 'core/init.php';
logged_in_redirect();
$version = "0.13 Alpha";
?>
<!DOCTYPE html> 
<html>
	<head> 
		<?php include 'includes/head.php'; ?>		
	</head>  
	<body>  
		<?php
		if(isset($_GET['success']) === true && empty($_GET['success']) === true){
		?>
			<div data-role="dialog" id="success">
				<div data-role="content">
					<p>
						Thanks, we've emailed you!
					</p>
					<a href="index.php" data-role="button">Continue</a>
				</div>
			</div><!--Page-->
		<?php
		}else if(isset($_GET['error'])){
		?>
			<div data-role="dialog" id="error">
				<div data-role="header" data-theme="c">
					<h1>
						<span style="font-size:16pt;font-weight:bold;">
							Account Recovery
						</span>
					</h1> 
				</div>
				<div data-role="content">
					<p>Oops, we couldn't find that email address</p>
				</div> <!--Content-->
			</div> <!--Dialog-->
			<div data-role="page" data-url="dialog.html" data-theme="c">
			</div><!-- /page -->
		<?php
		}else{
			$mode_allowed = array('username', 'password');
			if(isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_allowed) === true){
				 if(isset($_POST['email']) === true && empty($_POST['email']) === false){
					if(email_exists($_POST['email']) === true){
						recover($_GET['mode'], $_POST['email']);
						header('Location: recover.php?success');
						exit();
					}else{
					   header('Location: recover.php?error');
					   exit();
					}
					?>
					<div data-role="dialog" id="main" data-theme="c">
						<div data-role="header" data-theme="c"> 
							<h1>
								<span style="font-size:16pt;font-weight:bold;">
									Account Recovery
								</span>
							</h1> 
						</div><!-- header -->
						<div data-role="content">
							<form action="" method="post">
								<div data-role="fieldcontain" class="no-field-separator">
									 <label for="email">Your email:</label>
									 <input id="email" name="email" data-mini="true" type="email"/>
								</div>
								<div data-role="fieldcontain" class="no-field-separator">
									<label for="recover"></label>
									<input id="recover" type="submit" value="Recover" data-mini="true" data-inline="true"/>
								</div>
							</form>
						</div>
					</div><!-- /page -->
				<?php
				}else{
					header('Location: index.php');
					exit();
				}
			}
			ob_flush();
			?>
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
