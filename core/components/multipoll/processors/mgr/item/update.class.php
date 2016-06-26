<?php

/**
 * Update an Item
 */
class multiPollItemUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'multiPollItem';
	public $classKey = 'multiPollItem';
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
		$this->modx->log(1,(int)$this->getProperty('id'));
		$id = (int)$this->getProperty('id');
		$text = trim($this->getProperty('text'));
		if (empty($id)) {
			return $this->modx->lexicon('multipoll_item_err_ns');
		}

		if (empty($text)) {
			$this->modx->error->addField('text', $this->modx->lexicon('multipoll_item_err_text'));
		}
		elseif ($this->modx->getCount($this->classKey, array('text' => $text, 'id:!=' => $id))) {
			$this->modx->error->addField('text', $this->modx->lexicon('multipoll_item_err_ae'));
		}
		
		// ================================================================================= //

	        $culturekeys_list = $this->modx->getOption('multipoll_culturekeys_list',null,$this->modx->getOption('core_path').'components/multipoll/');
			$culturekeys_array = explode(',', $culturekeys_list);

			$question_id = $this->getProperty('id'); // Получаем id вновь созданного вопроса
			$question_text = $this->getProperty('text');
			$qObj = $this->modx->getObject($this->classKey, $question_id);
			
			if($this->getProperty('type') == 'radio') {
				$qObj->set('max_answer', '0');
				$qObj->save();
			}
			
			foreach ($culturekeys_array as $key => $value) {
				$arrayOfProperties = array(
				'data'			=> '{
										"name":"question_'.$question_id.'",
										"value":"'.$question_text.'",
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
				    return $this->modx->lexicon('xpoller2_translate_save_error');
				}
			}

			// ================================================================================= //
			
		return parent::beforeSet();
	}
}

return 'multiPollItemUpdateProcessor';
