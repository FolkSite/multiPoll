multiPoll.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'multipoll-panel-home', renderTo: 'multipoll-panel-home-div'
		}]
	});
	multiPoll.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(multiPoll.page.Home, MODx.Component);
Ext.reg('multipoll-page-home', multiPoll.page.Home);