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
		if (isset($_GET['success']) === true && empty($_GET['success']) === true) { 
	?>
		<div data-role="dialog" id="error">
			<div data-role="content">
				<p>Your acount has been activated!</p>
				<a href="indexRefresh.html" data-role="button" data-transition="flip">Continue</a>
			</div> <!--Content-->
		</div> <!--Dialog-->
	<?php		
		} else if (isset($_GET['email'], $_GET['email_code']) === true) {	
			$email      = trim($_GET['email']);
			$email_code = trim($_GET['email_code']);
			if (email_exists($email) === false) {
				$errors[] = 'Could not find email address.';
			} else if (activate($email, $email_code) === false) {
				$errors[] = 'We had problems activating your account';
			}
			if (empty($errors) === false) {
	?>
				<div data-role="dialog" id="error">
					<div data-role="header" data-theme="c">
						<h1>
							<span style="font-size:16pt;font-weight:bold;">
								Activation
							</span>
						</h1> 
					</div>
					<div data-role="content">
						<?php echo output_errors($errors); ?>
					</div> <!--Content-->
				</div> <!--Dialog-->
			<div data-role="page" data-url="dialog.html" data-theme="c"></div><!--This is needed to prevent multidialog bug-->	
	<?php  
			} else {
			header('Location: activate.php?success');	
			exit();          
			}
		}
		ob_flush();
	?>
					</div> <!-- /content -->
				</div> <!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
