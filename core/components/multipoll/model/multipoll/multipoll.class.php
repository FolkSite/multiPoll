<?php
/**
 * The base class for multiPoll.
 */
class multiPoll {
	/* @var modX $modx */
	public $modx;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('multipoll_core_path', $config, $this->modx->getOption('core_path') . 'components/multipoll/');
		$assetsUrl = $this->modx->getOption('multipoll_assets_url', $config, $this->modx->getOption('assets_url') . 'components/multipoll/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,
			'actionUrl' => $assetsUrl . 'action.php',
			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/'
		), $config);

		$this->modx->addPackage('multipoll', $this->config['modelPath']);
		$this->modx->lexicon->load('multipoll:default');
		$this->modx->lexicon->load('multipoll:translations'); // Подгружаем лексиконы компонента для переводов translations.inc.php
		if (!defined('MODX_API_MODE') || !MODX_API_MODE) {
			$this->modx->regClientScript($this->config['jsUrl'].'web/default.js');
			$this->modx->regClientCSS($this->config['cssUrl'].'web/default.css');
			$this->modx->regClientStartupScript(preg_replace('#(\n|\t)#', '', '
				<script type="text/javascript">
				multiPollConfig = {
					cssUrl: "' . $this->config['cssUrl'] . '",
					jsUrl: "' . $this->config['jsUrl'] . '",
					actionUrl: "' . $this->config['actionUrl'] . '"
				};
				</script>'), true);
			$this->modx->regClientStartupScript(preg_replace('#(\n|\t)#', '', '
			<script type="text/javascript">
			if (typeof jQuery == "undefined") {
				document.write("<script src=\"' . $this->config['jsUrl'] . 'web/lib/jquery.min.js\" type=\"text/javascript\"><\/script>");
			}
			</script>
			'), true);
		}
	}

}