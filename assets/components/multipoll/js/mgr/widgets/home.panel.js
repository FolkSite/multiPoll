multiPoll.panel.Home = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		layout: 'anchor',
		/*
		 stateful: true,
		 stateId: 'multipoll-panel-home',
		 stateEvents: ['tabchange'],
		 getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
		 */
		hideMode: 'offsets',
		items: [{
			html: '<h2>' + _('multipoll') + '</h2>',
			cls: '',
			style: {margin: '15px 0'}
		}, {
			xtype: 'modx-tabs',
			defaults: {border: false, autoHeight: true},
			border: true,
			hideMode: 'offsets',
			items: [{
				title: _('multipoll_items'),
				layout: 'anchor',
				items: [{
					html: _('multipoll_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'multipoll-grid-items',
					cls: 'main-wrapper',
				}]
			}]
		}]
	});
	multiPoll.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(multiPoll.panel.Home, MODx.Panel);
Ext.reg('multipoll-panel-home', multiPoll.panel.Home);
