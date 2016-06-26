multiPoll.window.CreateItem = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'multipoll-item-window-create';
	}
	Ext.applyIf(config, {
		title: _('multipoll_item_create'),
		width: 550,
		autoHeight: true,
		url: multiPoll.config.connector_url,
		action: 'mgr/item/create',
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
			fieldLabel: _('multipoll_item_name'),
			name: 'text',
			id: config.id + '-text',
			anchor: '99%',
			allowBlank: false,
		}, {
			xtype: 'textarea',
			fieldLabel: _('multipoll_item_description'),
			name: 'description',
			id: config.id + '-description',
			height: 150,
			anchor: '99%'
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('multipoll_item_active'),
			name: 'active',
			id: config.id + '-active',
			checked: true,
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('multipoll-item-window-create', multiPoll.window.CreateItem);


multiPoll.window.UpdateItem = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'multipoll-item-window-update';
	}
	Ext.applyIf(config, {
		title: _('multipoll_item_update'),
		width: 550,
		autoHeight: true,
		url: multiPoll.config.connector_url,
		action: 'mgr/item/update',
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
			fieldLabel: _('multipoll_item_name'),
			name: 'text',
			id: config.id + '-text',
			anchor: '99%',
			allowBlank: false,
		}, {
			xtype: 'textarea',
			fieldLabel: _('multipoll_item_description'),
			name: 'description',
			id: config.id + '-description',
			anchor: '99%',
			height: 150,
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('multipoll_item_active'),
			name: 'active',
			id: config.id + '-active',
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('multipoll-item-window-update', multiPoll.window.UpdateItem);