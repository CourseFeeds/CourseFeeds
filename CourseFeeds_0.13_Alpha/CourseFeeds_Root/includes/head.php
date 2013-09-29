<title>CourseFeeds</title> 
<!-- iOS Save to Homescreen Icon Support -->
<link rel="apple-touch-icon-precomposed" href="custom_icon_precomposed.png" />
<!-- iPhone Portrait -->
<link rel="apple-touch-startup-image" href="splash.png" />
<!-- iPad Portrait 768x1004 -->
<link rel="apple-touch-startup-image" href="ipad-portrait-retina.png" media="screen and (min-device-width: 1024px) and (max-device-width: 481px) and (orientation:portrait) and (-webkit-min-device-pixel-ratio: 2)" />
<!-- iPad Landscape 1024x748 -->
<link rel="apple-touch-startup-image" href="ipad-landscape-retina.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape) and (-webkit-min-device-pixel-ratio: 2)" />
<!-- Meta Tags -->
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSS Stylesheets -->
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
<link rel="stylesheet" href="/themes/CourseFeeds.css" />
<!-- JavaScript Scripts -->
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>	
<script type="text/javascript" src="http://my.twonky.com/plugins/beambutton/beam.js"></script>		
<script type="text/javascript">
	var _gaq = _gaq || [];
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
<?php
////////////// Get user's campus name (if signed in) ///////////////
$campus = htmlspecialchars($_GET["campus"]); // define variable campus
if(empty($_GET) && logged_in() === true){  // no data passed by get AND user is signed in
	$campus = $user_data['Campus'];
}else if(empty($_GET)){
	$campus = "University of Michigan";
}
?>
