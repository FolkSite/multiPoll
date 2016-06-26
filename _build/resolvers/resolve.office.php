<?php
/** @var modX $modx */
/** @var Office $office */
if ($Office = $modx->getService('office', 'Office', MODX_CORE_PATH . 'components/office/model/office/')) {

	if (!($Office instanceof Office)) {
		$modx->log(xPDO::LOG_LEVEL_ERROR, '[multiPoll] Could not register paths for Office component!');

		return true;
	}
	elseif (!method_exists($Office, 'addExtension')) {
		$modx->log(xPDO::LOG_LEVEL_ERROR, '[multiPoll] You need to update Office for support of 3rd party packages!');

		return true;
	}

	/**@var array $options */
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:
			$Office->addExtension('multiPoll', '[[++core_path]]components/multipoll/controllers/office/');
			$modx->log(xPDO::LOG_LEVEL_INFO, '[multiPoll] Successfully registered multiPoll as Office extension!');
			break;

		case xPDOTransport::ACTION_UNINSTALL:
			$Office->removeExtension('multiPoll');
			$modx->log(xPDO::LOG_LEVEL_INFO, '[multiPoll] Successfully unregistered multiPoll as Office extension.');
			break;
	}
}
else {
	$modx->log(xPDO::LOG_LEVEL_ERROR, '[multiPoll] Could not register paths for Office component!');
}

return true;