<?php

/**
 * Create an Item
 */
class multiPollItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'multiPollItem';
	public $classKey = 'multiPollItem';
	public $languageTopics = array('multipoll');
	//public $permission = 'create';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$text = trim($this->getProperty('text'));
		if (empty($text)) {
			$this->modx->error->addField('text', $this->modx->lexicon('multipoll_item_err_text'));
		}
		elseif ($this->modx->getCount($this->classKey, array('text' => $text))) {
			$this->modx->error->addField('text', $this->modx->lexicon('multipoll_item_err_ae'));
		}

		return parent::beforeSet();
	}
	public function afterSave() {
		// ================================================================================= //

        $culturekeys_list = $this->modx->getOption('multipoll_culturekeys_list',null,$this->modx->getOption('core_path').'components/multipoll/');
		$culturekeys_array = explode(',', $culturekeys_list);

		$question_id = $this->object->get('id'); // Получаем id вновь созданного вопроса
		$question_text = $this->getProperty('text');

		foreach ($culturekeys_array as $key => $value) {
			$arrayOfProperties = array(
	        'name' 			=> 'multipoll_q_'.$question_id,
	        'namespace'		=> 'multipoll',
	        'language' 		=> $value,
	        'topic' 		=> 'translations',
	        'value' 		=> $question_text);
	        $response = $this->modx->runProcessor('workspace/lexicon/create',$arrayOfProperties);
			if ($response->isError()) {
			    return $this->modx->lexicon('multipoll_translate_save_error');
			}
		}

		// ================================================================================= //
		return !$this->hasErrors();
	}
}

return 'multiPollItemCreateProcessor';