var multiPoll = function (config) {
	config = config || {};
	multiPoll.superclass.constructor.call(this, config);
};
Ext.extend(multiPoll, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}, renderer: {}
});
Ext.reg('multipoll', multiPoll);

multiPoll = new multiPoll();