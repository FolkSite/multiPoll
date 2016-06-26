<?php

/**
 * Class multiPollMainController
 */
abstract class multiPollMainController extends modExtraManagerController {
	/** @var multiPoll $multiPoll */
	public $multiPoll;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('multipoll_core_path', null, $this->modx->getOption('core_path') . 'components/multipoll/');
		require_once $corePath . 'model/multipoll/multipoll.class.php';

		$this->multiPoll = new multiPoll($this->modx);
		//$this->addCss($this->multiPoll->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->multiPoll->config['jsUrl'] . 'mgr/multipoll.js');
		$this->addHtml('
		<script type="text/javascript">
			multiPoll.config = ' . $this->modx->toJSON($this->multiPoll->config) . ';
			multiPoll.config.connector_url = "' . $this->multiPoll->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('multipoll:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends multiPollMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}