<?php

/**
 * Update an Item
 */
class multiPollOptionItemUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'multiPollOptionItem';
	public $classKey = 'multiPollOptionItem';
	public $languageTopics = array('multipoll');
	//public $permission = 'save';


	/**
	 * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return bool|string
	 */
	public function beforeSave() {
		if (!$this->checkPermissions()) {
			return $this->modx->lexicon('access_denied');
		}

		return true;
	}


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$id = (int)$this->getProperty('id');
		$poll_id = $this->getProperty('poll_id');
		$option_text = trim($this->getProperty('option_text'));
		if (empty($id)) {
			return $this->modx->lexicon('multipoll_item_err_ns');
		}
		if (empty($poll_id)) {
			return $this->modx->lexicon('multipoll_item_err_ns');
		}

		if (empty($option_text)) {
			$this->modx->error->addField('option_text', $this->modx->lexicon('multipoll_item_err_option_text'));
		}
		elseif ($this->modx->getCount($this->classKey, array('option_text' => $option_text, 'id:!=' => $id))) {
			$this->modx->error->addField('option_text', $this->modx->lexicon('multipoll_item_err_ae'));
		}
		
		// ================================================================================= //
		$culturekeys_list = $this->modx->getOption('multipoll_culturekeys_list',null,$this->modx->getOption('core_path').'components/multipoll/');
		$culturekeys_array = explode(',', $culturekeys_list);

		$option_id = $this->getProperty('id');
		$option_text = $this->getProperty('option_text');
		$qid = $this->modx->getObject($this->classKey, array(
			'id' => $this->getProperty('id'),
		));
		$option_translations = $qid->get('qid') . '_' . $option_id;

			foreach ($culturekeys_array as $key => $value) {
				$arrayOfProperties = array(
				'data'			=> '{
										"name":"option_'.$option_translations.'",
										"value":"'.$option_text.'",
										"namespace":"multipoll",
										"topic":"translations",
										"language":"'.$value.'",
										"editedon":'.time().',
										"overridden":1,
										"menu":null
									}',
	        	);
	        	$response = $this->modx->runProcessor('workspace/lexicon/updatefromgrid',$arrayOfProperties);

				if ($response->isError()) {
				    return $this->modx->lexicon('multipoll_translate_save_error');
				}
			}

			// ================================================================================= //

		return parent::beforeSet();
	}
}

return 'multiPollOptionItemUpdateProcessor';
