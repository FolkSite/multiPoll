<?php

/**
 * Create an Item
 */
class multiPollOptionItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'multiPollOptionItem';
	public $classKey = 'multiPollOptionItem';
	public $languageTopics = array('multipoll');
	//public $permission = 'create';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$option_text = trim($this->getProperty('option_text'));
		$poll_id = trim($this->getProperty('poll_id'));
		if (empty($option_text)) {
			$this->modx->error->addField('option_text', $this->modx->lexicon('multipoll_item_err_option_text'));
		}
		elseif ($this->modx->getCount($this->classKey, array('option_text' => $option_text))) {
			$this->modx->error->addField('option_text', $this->modx->lexicon('multipoll_item_err_ae'));
		}

		return parent::beforeSet();
	}
	public function afterSave() {

    	// ================================================================================= //
    	$c = $this->modx->newQuery($this->classKey);
        $c->sortby('rank','DESC');
        $c->limit(1);
        $c->prepare();
        $c->stmt->execute();
        $lastQuests = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
        $lastQuest = array_shift($lastQuests);
        $rank = $lastQuest[$this->classKey.'_rank'] + 1;
        $this->setProperty('rank', $rank);

    	$culturekeys_list = $this->modx->getOption('multipoll_culturekeys_list',null,$this->modx->getOption('core_path').'components/multipoll/');
		$culturekeys_array = explode(',', $culturekeys_list);

		$option_id = $this->object->get('id');
		$option_text = $this->getProperty('option_text');
        $question_id = $this->getProperty('poll_id');

		foreach ($culturekeys_array as $key => $value) {
			$arrayOfProperties = array(
	        'name' 			=> 'multipoll_q_'.$question_id.'_o_'.$option_id,
	        'namespace'		=> 'multipoll',
	        'language' 		=> $value,
	        'topic' 		=> 'translations',
	        'value' 		=> $option_text);
	        $response = $this->modx->runProcessor('workspace/lexicon/create',$arrayOfProperties);
			if ($response->isError()) {
			    return $this->modx->lexicon('multipoll_translate_save_error');
			}
		}

		// ================================================================================= //
		return !$this->hasErrors();
		
	}
}

return 'multiPollOptionItemCreateProcessor';