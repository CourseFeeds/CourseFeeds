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
						Report Comment
					</span>
				</h1> 
			</div><!-- header -->
			<div data-role="content" data-theme="b">
				<h4>
					Please provide the comment violation type and any details you wish to share.<br /><br />
					We take comment violations seriously and appreciate your assistance in keeping CourseFeeds clean of bad comments.
				</h4>
				<?php
				$reportCommentID = htmlspecialchars($_GET["reportCommentID"]);
				$linkID = htmlspecialchars($_GET["linkID"]);
				echo'
				<form action="reportCommentSubmit.php?reportCommentID='.$reportCommentID.'&linkID='.$linkID.'" method="get">
					<ul data-role="listview" data-prevent-focus-zoom="true" data-inset="true" data-theme="c">
						<li>
							<div data-role="fieldcontain">
								<fieldset data-role="controlgroup">
									<legend>
										<h2>
											Violations:
										</h2>
									</legend>
									<label for="select-choice-violation"> Choose one: </label>
									<select name="select-choice-violation" id="select-choice-violation" data-theme="c">
										<option>Choose one...</option>						
										<option value="Profanity">Profanity</option>
										<option value="Advertisement Content">Advertisement Content</option>
										<option value="Answers to Homework">Answers to Homework</option>
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
							<button type="submit" data-theme="b" name="submit" value= "submit" class="ui-btn-hidden" aria-disabled="false">
								Report Comment
							</button>
						</li>
					</ul>';
				?>
			</div> <!-- content-->
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
