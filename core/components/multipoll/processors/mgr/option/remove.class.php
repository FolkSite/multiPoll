<?php

/**
 * Remove an Items
 */
class multiPollOptionItemRemoveProcessor extends modObjectProcessor {
	public $objectType = 'multiPollOptionItem';
	public $classKey = 'multiPollOptionItem';
	public $languageTopics = array('multipoll');
	//public $permission = 'remove';

	public function beforeRemove() {
		// ================================================================================= //

    	$culturekeys_list = $this->modx->getOption('multipoll_culturekeys_list',null,$this->modx->getOption('core_path').'components/multipoll/');
		$culturekeys_array = explode(',', $culturekeys_list);

		$option_id = $this->object->get('id');
        $qid = $this->modx->getObject($this->classKey, array( 'poll_id' => $option_id ));

		foreach ($culturekeys_array as $key => $value) {
			$arrayOfProperties = array(
	        'name' 			=> 'multipoll_q_'. $qid->get('qid') . '_o_' . $option_id,
	        'namespace'		=> 'multipoll',
	        'language' 		=> $value,
	        'topic' 		=> 'translations');
	        $response = $this->modx->runProcessor('workspace/lexicon/revert',$arrayOfProperties);
			if ($response->isError()) {
			    return $this->modx->lexicon('multipoll_translate_save_error');
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
			return $this->failure($this->modx->lexicon('multipoll_option_item_err_ns'));
		}

		foreach ($ids as $id) {
			
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('multipoll_option_item_err_nf'));
			}

			$object->remove();
		}

		return $this->success();
	}

}

return 'multiPollOptionItemRemoveProcessor';