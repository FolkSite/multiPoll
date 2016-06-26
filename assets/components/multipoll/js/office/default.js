Ext.onReady(function() {
	multiPoll.config.connector_url = OfficeConfig.actionUrl;

	var grid = new multiPoll.panel.Home();
	grid.render('office-multipoll-wrapper');

	var preloader = document.getElementById('office-preloader');
	if (preloader) {
		preloader.parentNode.removeChild(preloader);
	}
});