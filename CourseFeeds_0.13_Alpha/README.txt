CourseFeeds Project Documentation
Version 0.13 Alpha | 09/29/2013 | Demo: CourseFeeds.com | Contact: cwoolf@umich.edu

1. GitHub Repository
GitHub is a website focused on collaborative software development. Hosting code written by novice developers all the way up to code written by massive corporations, such as Google and Twitter, GitHub is centered on the Git revision control system. Git allows software developers to work simultaneously on the same files, as well as merge or fork file revisions.
The entire CourseFeeds codebase can be downloaded and reused based on the MIT License terms and conditions that can be found below. Anyone can contribute to the open source project by using the fork option. Forking a project allows multiple, separately contained, versions to coexist and be merged into the master branch in future versions if desired.

CourseFeeds Project GitHub URL:
https://github.com/CourseFeeds

The MIT License (MIT)
Copyright (c) 2013 CourseFeeds Development Team
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

2. File Descriptions grouped by Directory

Root Directory – 54 Items  ~ 34 MB
File	Description
about.php	Static content about the CourseFeeds Project 
activate.php	Script for new account activation
addlink.php	Form for submitting new links
addlinkSubject.php	Select subject of course or go directly to My Courses
beam.php	Twonky Beam API based streaming option
browse.php	Select institution and subject of course
changepassword.php	Dialog for changing a user’s password
commentdeleting.php	Script for deleting a user’s comment
/core	Directory for account system scripts
course.php	Select a link related to a specific course
courses.php	Select a specific course from a single subject
custom_icon_precomposed.png	Web-App icon for iOS-Safari’s Add to Home Screen 
deleteComment.php	Dialog for deleting a user’s comment
deleteLink.php	Dialog for deleting a user’s link
deletestar.php	Dialog for un-starring a link
email.php	Dialog for newsletter subscription form
enroll.php	Dialog for adding course to My Courses
favorites.php	Manually saved links (bookmarks) 
forgot-password.php	Password recovery form
/images	Directory for all images referenced (relative)
/includes	Directory for commonly used PHP snippets
index.php	Home page, default point of entry
indexRefresh.html	Redirect, used to cause a full page refresh of index.php
ipad-landscape-retina.png	Loading image for iOS Home Screen version (Horiz.) 
ipad-portrait-retina.png	Loading image for iOS Home Screen version (Vert.) 
legal.php	Dialog for license terms and conditions
linkdeleting.php	Script for deleting links
linkdetails.php	Page for displaying link information
login.php	Script for signing into account
loginForm.php	Dialog for signing into account
logout.php	Script for signing out of account
modApp.php	Dialog for moderator application form (incomplete)
protected.php	Dialog for failed requirement alert 
quickstart.php	Pages for introductory walkthrough
recover.php	Dialog for username/password recovery form
register.php	Dialog for new account creation form
reportBug.php	Dialog for bug report form
reportComment.php	Dialog for comment violation report form
reportCommentSubmit.php	Script for comment violation report
reportLink.php	Dialog for link violation report form
reportLinkSubmit.php	Script for link violation report
requestCampus.php	Dialog for campus request form
settings.php	Dialog for account settings form
splash.png	Loading image for iOS Home Screen version (iPhone) 
star.php	Dialog for saving link to Favorites (starred links)
student.php	Page for links submitted by specific student
students.php	Page for students enrolled in specific course
subjectlinkdetails.php	Page for subject link information
submitcomment.php	Script for submitting new comment
techSupport.php	Dialog for technical support form
/themes
unenroll.php	Directory for CSS style-sheet(s) and jQuery images 
Dialog for removing course from My Courses
unstar.php	Dialog for removing a link from Favorites

Core Directory – 3 Items  ~ 36 KB
File	Description
/database	Directory for MYSQL database related files
/functions	Directory for commonly used PHP snippets
init.php	Session initialization script

Database Directory – 3 Items  ~ 36 KB
File	Description
connect.php	Script for connecting to MYSQL database
CourseFeeds_Structure.sql	SQL code for importing tables used in MYSQL database

Functions Directory – 3 Items  ~ 36 KB
File	Description
general.php	Commonly used PHP functions
users.php	Functions related to user account system

Images Directory – 8 Items  ~ 5.1 MB
File	Description
/about	Images for about.php dialog
/index_slideshow	Images for index.php slideshow
menuBg.gif	Default jQuery Mobile image
menuIconsSprite.png	Default jQuery Mobile image
/navicons	Images for global navigation in footer
/quickstart	Images for quickstart.php
/special	Images for button icons and backgrounds
/subjects	Images for subject icons



Includes Directory – 4 Items  ~ 13 KB
File	Description
analytics.php	Google Analytics Code Snippet
head.php	Global <head> HTML section
panelCompact.php	Global slide-out menu
slideshow.php	JavaScript snippet for index.php slideshow

Themes Directory – 2 Items  ~ 101 KB
File	Description
CourseFeeds.css	Global CSS style-sheet
/images	Default jQuery Mobile images

 
3. Getting Started: Initial Setup and Configuration of CourseFeeds

A. Requirements:
•	Administrator account permission for software installation
•	Computer running Windows (7+) or Mac OS (10.6+)
•	WAMP, XAMP, or MAMP (Free Software)
•	Chrome, FireFox, Opera, or Safari (Recommended Browsers)
•	List of courses (in CSV, Excel, or SQL formats) with relevant meta-data (course numbers, names, subjects, etc.)
•	List of subjects (in CSV, Excel, or SQL formats) that match subjects attribute within list of courses 
•	Linux or Windows based webserver (optional)

B. Download Zip file from GitHub and unzip (extract) the file
(See Part 1. for related GitHub details)

C. Download and install WAMP (Windows), XAMP (Windows), or MAMP (Mac OS X) 
Of note, WAMP is the program demonstrated in this guide.
Official WAMP Description:
“WampServer is a Windows web development environment. It allows you to create web applications with Apache2, PHP and a MySQL database. Alongside, PhpMyAdmin allows you to manage easily your databases.”

D. Copy the contents within the “CourseFeeds_Root” folder to the “www” folder (inside “wamp” folder)

E. Convert Excel files into CSVs 
Short tutorial: http://www.youtube.com/watch?v=diEwQk4uY14 

F. Launch phpMyAdmin from within WAMP toolbar menu. Unless previously reconfigured, the default username is “root” and the default password is empty (no password).

G. Create CourseFeeds database via phpMyAdmin

H. Import included SQL file into CourseFeeds database via phpMyAdmin
CourseFeeds_Root/core/database/C342425_CourseFeeds_Structure.sql

I. Import a CSV file for each of the required tables or manually enter schools, subjects, and courses (required tables) into tables using phpMyAdmin’s built in data entry tools.
Note: For best results, use “CVS using LOAD DATA” as the loading format within the Import page.
