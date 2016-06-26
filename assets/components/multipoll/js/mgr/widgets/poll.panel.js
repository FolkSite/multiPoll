multiPoll.panel.Poll = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		id: 'multipoll-panel-poll',
		layout: 'anchor',
		hideMode: 'offsets',
		url: multiPoll.config.connectorUrl,
		baseParams: {
            action: 'mgr/item/update',
            id: MODx.request.id
        },
		useLoadingMask: true,
		items: this.getItems(config),
		listeners: {
            'setup': {
                fn: this.setup
                ,scope: this
            }
            ,'success': {
                fn: this.success
                ,scope: this
            }
        }
	});
	
	multiPoll.panel.Poll.superclass.constructor.call(this, config);
};
Ext.extend(multiPoll.panel.Poll, MODx.FormPanel, {
	setup: function() {
        if (this.config.isUpdate) {
            MODx.Ajax.request({
                url: this.config.url
                ,params: {
                    action: 'mgr/item/get'
                    ,id: MODx.request.id
                },
                listeners: {
                    'success': {
                        fn: function(r) {
                            this.getForm().setValues(r.object);
                            // console.log(r.object);
                            // Ext.getCmp('asdfasdfasdfa').setValue(r.object.active);
                            this.fireEvent('ready', r.object);
                            MODx.fireEvent('ready');
                        },
                        scope: this
                    }
                }
            });
        } else {
            this.fireEvent('ready');
            MODx.fireEvent('ready');
        }
    }


    ,success: function(o, r) {
        if (this.config.isUpdate == false) {
            MODx.loadPage(MODx.action['multipoll:index'], 'action=poll/update&id='+ o.result.object.id);
        }
    }
	,getItems: function(config) {
		console.log(config);
        return [{
            html: '<h2>' + _('multipoll_item_update') + '</h2>'
            ,border: false
            ,cls: 'modx-page-header'
            ,style: {margin: '15px 0'}
        },{
            name: 'id'
            ,xtype: 'hidden'
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
	                defaults: {
	                    msgTarget: 'side'
	                    ,autoHeight: true
	                }
	                ,cls: 'form-with-labels'
	                ,border: false
	                ,items: [{
	                    layout: 'column'
	                    ,border: false
	                    ,cls: 'main-wrapper'
	                    ,height: 100
	                    ,defaults: {
	                        layout: 'form'
	                        ,labelAlign: 'top'
	                        ,labelSeparator: ''
	                        ,anchor: '100%'
	                        ,border: false
	                    }
	                    ,items: [{
	                        columnWidth: 0.7
	                        ,border: false
	                        ,defaults: {
	                            msgTarget: 'under'
	                        }
	                        ,items: [{
	                            xtype: 'textfield'
	                            ,fieldLabel: _('multipoll_item_name')
	                            ,name: 'text'
	                            ,anchor: '100%'
	                            ,allowBlank: false
	                        },{
	                            xtype: 'textarea'
	                            ,fieldLabel: _('multipoll_item_description')
	                            ,name: 'description'
	                            ,anchor: '100%'
	                        }]
	                    },{
	                        columnWidth: 0.3
	                        ,border: false
	                        ,defaults: {
	                            msgTarget: 'under'
	                        }
	                        ,items: [{
	                            xtype: 'xcheckbox'
	                            ,fieldLabel: _('multipoll_item_active')
	                            ,name: 'active'
	                            ,anchor: '100%'
	                            ,id: 'active'
	                        }]
	                    }]
	                }]
	            }, {
					xtype: 'multipoll-grid-poll',
					cls: 'main-wrapper',
				}]
			}, {
    			title: _('multipoll_lexicon'),
    			layout: 'anchor',
				items: [{
					html: _('multipoll_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'multipoll-grid-lexicon',
					cls: 'main-wrapper',
				}]
			}]
		}];
    }
});
Ext.reg('multipoll-panel-poll', multiPoll.panel.Poll);
