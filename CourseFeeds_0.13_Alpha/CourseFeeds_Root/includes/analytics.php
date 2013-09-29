<!-- Google Analytics Javascript Code -->
<script type="text/javascript">
	$('[data-role=page]').live('pageshow', function (event, ui) {
		try {
			_gaq.push(['_setAccount', 'UA-55555555-5']); // Change to your unique Google Analytics Tracking Code
			hash = location.hash;
			if (hash) {
				_gaq.push(['_trackPageview', hash.substr(1)]);
			} else {
				_gaq.push(['_trackPageview']);
			}
		} catch(err) {
		}
	});
</script>
