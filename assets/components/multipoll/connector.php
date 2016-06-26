<?php
// /** @noinspection PhpIncludeInspection */
// require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
// /** @noinspection PhpIncludeInspection */
// require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
// /** @noinspection PhpIncludeInspection */
// require_once MODX_CONNECTORS_PATH . 'index.php';
// /** @var multiPoll $multiPoll */
// $multiPoll = $modx->getService('multipoll', 'multiPoll', $modx->getOption('multipoll_core_path', null, $modx->getOption('core_path') . 'components/multipoll/') . 'model/multipoll/');
// $modx->lexicon->load('multipoll:default');

// // handle request
// $corePath = $modx->getOption('multipoll_core_path', null, $modx->getOption('core_path') . 'components/multipoll/');
// $path = $modx->getOption('processorsPath', $multiPoll->config, $corePath . 'processors/');
// $modx->request->handleRequest(array(
// 	'processors_path' => $path,
// 	'location' => '',
// ));

// ===== For debug =====
ini_set('display_errors', 1);
ini_set('error_reporting', -1);

// Load MODX config
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
	require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
}
else {
	require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}

require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('multipoll_core_path', null, $modx->getOption('core_path') . 'components/multipoll/');
require_once $corePath . 'model/multipoll/multipoll.class.php';
$modx->multipoll = new multipoll($modx);
$modx->lexicon->load('multipoll:default');

/* handle request */
$path = $modx->getOption('processorsPath', $modx->multipoll->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));