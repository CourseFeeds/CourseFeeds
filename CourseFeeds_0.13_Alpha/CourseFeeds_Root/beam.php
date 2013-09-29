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
		<div data-role="page" data-add-back-btn="true">
			<div data-role="panel" id="mypanel" class="ui-responsive" data-theme="d" data-position="right" data-display="overlay" data-dismissible="true">
				<?php include 'includes/panelCompact.php'; ?>				
			</div><!-- /panel -->
			<?php
			$today = time(); //gets current date string
			$timestamp = $today - 604800; //sets timestamp to 7 days ago
			$newDate = date("Y-m-d H:i:s", $timestamp); //changes timestamp to date string
			$URL	 = urldecode($_GET["URL"]); // pass url from link details page via url variable "url"
			$media 	 = urldecode($_GET["media"]); // pass mediatype from link details page via url variable "media"
			$embed   = urldecode($_GET["embed"]); //gets the embedded format of the video that is attempting to be beamed
			$refresh = urldecode($_GET["refresh"]); // pass url from link details page via url variable "url"	
			
			if(! $refresh == 1){
				echo'
					<script type="text/javascript">
						window.location.href = window.location.href + "&refresh=1";
					</script>
				';
			}
			echo '
			<div data-role="header" data-theme="c" data-position="fixed">		
				<h1>
					<span style="font-size:14pt; color: #21445b;">
						Beam
					</span>
				</h1>			
				<a href="#mypanel" class="ui-btn-right" data-corners="false" style="width:40px;height:30px;">
					<img src="../images/special/Menu.png" style="width:25px;margin-left:-3px;margin-top:-5px;" />
				</a>
			</div><!-- /header -->';
			echo'
			<div data-role="content">
				<div class="pv-twonky-beam" data-href="'.$URL.'" >
					<iframe width="100%" height="380" src="'.$embed.'" frameborder="0" allowfullscreen></iframe>
				</div>
				<ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="d" class="ui-listview ui-listview-inset ui-corner-none ui-shadow">
					<li data-role="list-divider" role="heading" data-divider-theme="d" class="ui-li ui-li-divider ui-bar-d ui-corner-none">Basic Instructions</li>
					<li>Important: This feature requires additional software in order to function properly.</li>
					<li>Once the appropriate software has been installed, press the Beam button (above) to beam the media to a compatible device.</li>
					<li>Twonky Beam is a PacketVideo technology that allows content (such as YouTube videos) to be streamed wirelessly to supported devices.
					For a detailed list of supported devices, please visit PacketVideo\'s Twonky website.</li>
				</ul>
				<ul data-role="listview" data-inset="true" data-theme="c" data-divider-theme="b" class="ui-listview ui-listview-inset ui-corner-none ui-shadow" style="margin-bottom:47px;">		
					<li data-role="list-divider" role="heading"  class="ui-li ui-li-divider ui-bar-d ui-corner-none">Device Compatibility and Software Downloads</li>
					<li><a href="http://twonky.com/devices/" target="_blank" rel="external">Compatible Devices</a></li>
					<li><a href="http://twonky.com/downloads/" target="_blank" rel="external">Linux, Mac, and Windows Twonky Server</a></li>
					<li><a href="https://play.google.com/store/apps/details?id=com.pv.twonkybeam&hl=en" target="_blank" rel="external">Android Twonky Beam Browser</a></li>
					<li><a href="http://itunes.apple.com/us/app/twonky-beam/id445754456?mt=8" target="_blank" rel="external">iOS Twonky Beam Browser</a></li>
				</ul>	
			</div><!-- /content -->';	
			?>	
		</div><!-- /page -->
		<?php include 'includes/analytics.php'; ?>
	</body>
</html>
