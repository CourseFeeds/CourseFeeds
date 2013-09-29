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
		<div data-role="page">	
			<div data-role="header" data-theme="c"> 		
				<h1><span style="font-size:16pt;font-weight:bold;">About</span></h1> 			
			</div> <!-- header -->			
			<div data-role="content">			
				<ul data-role="listview" data-theme="c" data-divider-theme="b" class="ui-listview ui-shadow">			
					<div style="position:relative;padding:0;">		
						<img style="max-width: 100%;" src="images/about/aboutHead.png" />				
						<li data-role="list-divider" role="heading" data-divider-theme="a" class="ui-li ui-li-divider ui-bar-c">
							&nbsp;Development Team
						</li>			
						<img style="max-width: 100%;" src="images/about/about_team_photo.jpg" />		
						<li>
							<div style="font-size:9pt; font-weight:bold; text-align: center; padding: 5px 10px 0px 10px;">
								Salvador Holguin, Cory Woolf, Cory VanHooser, and Brandon Wenzel
							</div>
						</li>		
						<li data-role="list-divider" role="heading" data-divider-theme="a" 
						class="ui-li ui-li-divider ui-bar-c" style="margin:10px 0 10px 0;">
							&nbsp;Project Description
						</li>
					</div>
					<li style="margin-top:-10px;">
						<div style="font-size:10pt; font-weight:normal;padding: 0px 20px 0px 20px; line-height:150%">
							As the focus of the University of Michigan-Dearborn
							2012 Summer Engineering Project, CourseFeeds is
							the product of an idea that began in June 2012.
							Cory Woolf, creator of weStudy, recognized the
							advantages that social aggregation websites
							such as Reddit and Digg offer users trying to find
							relevant news. Instead of having a small group of people decide 
							what content should be spotlighted, Woolf believes that a democratic 
							(vote-based) system would be more powerful than an oligarchy (editor-based)
							system for finding high-quality educational content.
							<br /><br />
							Together, team members Salvador Holguin (Web Authentication), 
							Cory VanHooser (Database, Querying), Brandon Wenzel (Database, Querying), 
							and Cory Woolf (UI, Marketing) worked on the project 
							directed by Roger Shulze (IAVS Director).
							With funding provided by
							Jim Brailean (Co-Founder and CEO at BFT Equity Partners), the all
							undergraduate student development team
							designed and implemented the web-app using the jQuery
							Mobile Framework. The primary languages utilized
							include HTML5, CSS3, Javascript, PHP, and MYSQL.
							<br /><br />
							CourseFeeds allows students and professors to
							submit helpful academic resources in the form of a
							URL. Instead of hosting multimedia content,
							CourseFeeds embeds multimedia content
							whenever possible, offering a link to any content
							that can't be embedded. YouTube and Vimeo
							videos are automatically embedded into the Link
							Details page, while PDF's, Web-pages, and other
							content are accessible through a link.
							<br /><br />
							Course names, total votes, keywords, media-types,
							and other meta-data associated with each
							submission can make sorting and searching for
							relevant academic resources faster than using
							traditional search engines such as Google, Yahoo,
							and Bing. The ability to view resources submitted
							during previous semesters makes it easy to locate
							resources relevant to your specific course and time
							of semester. 
							<br /><br />
							For example, resources submitted for a
							particular course during the fourth week of a
							previous semester are likely to be highly relevant to
							a student that's currently in the same course and in
							the fourth week of the semester.
							<br /><br />
							Entered into the <a href="http://mobileapps.umich.edu/content/
							winners-fall-2012-u-m-mobile-apps-challenge" target="_blank">
							Fall 2012 University of Michigan Mobile Apps Challenge</a>, 
							CourseFeeds placed 1st in the Education and Web-App Categories, as well 
							as 5th place for Best Overall App.
							Photo by Joseph Xu (Ann Arbor, MI)	
						</div>
					</li>
					<img style="max-width:  100%;" src="images/about/aboutFooter.png" />	 
				</ul> 
			</div><!--Content-->
		</div> <!--Page-->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
