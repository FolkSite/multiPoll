multiPoll.window.CreateItem = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'multipoll-poll-window-create';
	}
	Ext.applyIf(config, {
		title: _('multipoll_item_create'),
		width: 650,
		autoHeight: true,
		url: multiPoll.config.connector_url,
		baseParams: {
            action: 'mgr/option/create'
            ,poll_id: MODx.request.id
        },
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	multiPoll.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(multiPoll.window.CreateItem, MODx.Window, {

	getFields: function (config) {
		return [{
			xtype: 'textfield',
			fieldLabel: _('multipoll_options_item_text'),
			name: 'option_text',
			id: config.id + '-option_text',
			anchor: '99%',
			allowBlank: false,
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('multipoll_item_active'),
			name: 'active',
			id: config.id + '-active',
			checked: true,
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('multipoll_options_item_right'),
			name: 'right',
			id: config.id + '-right',
			checked: false,
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('multipoll-poll-window-create', multiPoll.window.CreateItem);


multiPoll.window.UpdateItem = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'multipoll-poll-window-update';
	}
	Ext.applyIf(config, {
		title: _('multipoll_item_update'),
		width: 650,
		autoHeight: true,
		url: multiPoll.config.connector_url,
		action: 'mgr/option/update',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	multiPoll.window.UpdateItem.superclass.constructor.call(this, config);
};

Ext.extend(multiPoll.window.UpdateItem, MODx.Window, {
	
	getFields: function (config) {
		return [{
			xtype: 'hidden',
			name: 'id',
			id: config.id + '-id',
		}, {
			xtype: 'textfield',
			fieldLabel: _('multipoll_options_item_text'),
			name: 'option_text',
			id: config.id + '-option_text',
			anchor: '99%',
			allowBlank: false,
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('multipoll_item_active'),
			name: 'active',
			id: config.id + '-active',
			checked: true,
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('multipoll_options_item_right'),
			name: 'right',
			id: config.id + '-right',
			checked: false,
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('multipoll-poll-window-update', multiPoll.window.UpdateItem);