<?php

/**
 * Remove an Items
 */
class multiPollItemRemoveProcessor extends modObjectProcessor {
	public $objectType = 'multiPollItem';
	public $classKey = 'multiPollItem';
	public $languageTopics = array('multipoll');
	//public $permission = 'remove';
	
	public function beforeRemove() {
		// ================================================================================= //

    	$culturekeys_list = $this->modx->getOption('multipoll_culturekeys_list',null,$this->modx->getOption('core_path').'components/multipoll/');
		$culturekeys_array = explode(',', $culturekeys_list);

		$qid = $this->object->get('id');

		foreach ($culturekeys_array as $key => $value) {
			$arrayOfProperties = array(
	        'name' 			=> 'question_'. $qid,
	        'namespace'		=> 'multipoll',
	        'language' 		=> $value,
	        'topic' 		=> 'translations');
	        $response = $this->modx->runProcessor('workspace/lexicon/revert',$arrayOfProperties);
			if ($response->isError()) {
			    return $this->modx->lexicon('multipoll_translate_save_error');
			}

			$options = $this->modx->getCollection('multiPollOptionItem',array('poll_id' => $qid));
			foreach ($options as $res) {
				$arrayOfProperties_options = array(
		        'name' 			=> 'option_'. $qid . '_' . $res->get('id'),
		        'namespace'		=> 'multipoll',
		        'language' 		=> $value,
		        'topic' 		=> 'translations');
		        $response_options = $this->modx->runProcessor('workspace/lexicon/revert',$arrayOfProperties_options);
				if ($response_options->isError()) {
				    return $this->modx->lexicon('multipoll_translate_save_error');
				}
			}
		}

		// ================================================================================= //

		if ($this->hasErrors()) {
            return false;
        }
		return !$this->hasErrors();
	}

	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('multipoll_item_err_ns'));
		}

		foreach ($ids as $id) {
			/** @var multiPollItem $object */
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('multipoll_item_err_nf'));
			}

			$object->remove();
		}

		return $this->success();
	}

}

return 'multiPollItemRemoveProcessor';