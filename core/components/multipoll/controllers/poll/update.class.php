<?php

/**
 * The home manager controller for multiPoll.
 *
 */
class multipollPollUpdateManagerController extends multiPollMainController {
	/* @var multiPoll $multiPoll */
	public $multiPoll;


	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('multipoll');
	}


	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addCss($this->multiPoll->config['cssUrl'] . 'mgr/main.css');
		$this->addCss($this->multiPoll->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
		$this->addJavascript($this->multiPoll->config['jsUrl'] . 'mgr/misc/utils.js');
		$this->addJavascript($this->multiPoll->config['jsUrl'] . 'mgr/widgets/poll.grid.js');
		$this->addJavascript($this->multiPoll->config['jsUrl'] . 'mgr/widgets/lexicon.grid.js');
		$this->addJavascript($this->multiPoll->config['jsUrl'] . 'mgr/widgets/poll.windows.js');
		$this->addJavascript($this->multiPoll->config['jsUrl'] . 'mgr/widgets/poll.panel.js');
		$this->addJavascript($this->multiPoll->config['jsUrl'] . 'mgr/sections/poll.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "multipoll-page-poll"});
		});
		</script>');
	}


	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->multiPoll->config['templatesPath'] . 'poll.tpl';
	}
}