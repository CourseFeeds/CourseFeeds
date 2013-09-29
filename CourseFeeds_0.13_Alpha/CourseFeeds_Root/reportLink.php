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
		<div data-role="page" data-theme="b">
			<div data-role="header" data-theme="c"> 	
				<h1>
					<span style="font-size:16pt;font-weight:bold;">
						Report Link
					</span>
				</h1> 
			</div><!-- header -->
			<div data-role="content" data-theme="b">
				<h4>
					Please provide the link violation type and any details you wish to share.<br /><br />
					We take link violations seriously and appreciate your assistance in keeping CourseFeeds clean of bad links.
				</h4>
				<?php			
				$reportLink = htmlspecialchars($_GET["reportLink"]);
				echo'
				<form action="reportLinkSubmit.php?reportLink='.$reportLink.'" method="get">
					<ul data-role="listview" data-prevent-focus-zoom="true" data-inset="true" data-theme="c">
						<li>
							<div data-role="fieldcontain">
								<fieldset data-role="controlgroup">
									<legend>
										<h2>
											Violations:
										</h2>
									</legend>
									<label for="select-choice-violation"> 
										Choose one of the following: 
									</label>
									<select name="select-choice-violation" id="select-choice-violation" data-theme="c">
										<!--<option>Choose one</option>-->					
										<option value="Sexual Content">Sexual Content</option>
										<option value="Advertisement">Advertisement Content</option>
										<option value="Answers to Homework">Answers to Homework</option>
										<option value="Dead Link">Dead Link</option>
										<option value="Non-Academic Related">Non-Academic Related</option>	
										<option value="Other">Other</option>
									</select>	
								</fieldset>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="textarea">
									<h2> 
										Details: 
									</h2>
								</label>
								<textarea rows="30" cols="30" name="textarea" id="textarea"></textarea>
							</div>
						</li>
						<li>
							<button type="submit" data-theme="b" name="submit" value="name" class="ui-btn-hidden" aria-disabled="false">
								Report Link
							</button>
						</li>
					</ul>';?>
				</form>
			</div> <!-- content-->
		</div><!-- /page -->
	</body>
	<?php include 'includes/analytics.php'; ?>
</html>
