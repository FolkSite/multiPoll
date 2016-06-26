multiPoll.page.Poll = function (config) {
	config = config || {};
	config.isUpdate = (MODx.request.id) ? true : false;
	Ext.applyIf(config, {
		formpanel: 'multipoll-panel-poll'
        ,buttons: [{
            text: _('save')
            ,method: 'remote'
            ,process: config.isUpdate ? 'mgr/item/update' : 'mgr/item/create'
            ,cls: 'primary-button'
            ,keys: [{
                key: MODx.config.keymap_save || 's'
                ,ctrl: true
            }]
        },{
            text: 'Назад'
            ,params: {a: MODx.request.a}
        }]
		,components: [{
			xtype: 'multipoll-panel-poll', 
			renderTo: 'multipoll-panel-poll-div',
			isUpdate: config.isUpdate
		}]
	});
	multiPoll.page.Poll.superclass.constructor.call(this, config);
};
Ext.extend(multiPoll.page.Poll, MODx.Component);
Ext.reg('multipoll-page-poll', multiPoll.page.Poll);