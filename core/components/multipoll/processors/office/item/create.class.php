<?php

/**
 * Create an Item
 */
class multiPollOfficeItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'multiPollItem';
	public $classKey = 'multiPollItem';
	public $languageTopics = array('multipoll');
	//public $permission = 'create';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$name = trim($this->getProperty('name'));
		if (empty($name)) {
			$this->modx->error->addField('name', $this->modx->lexicon('multipoll_item_err_name'));
		}
		elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
			$this->modx->error->addField('name', $this->modx->lexicon('multipoll_item_err_ae'));
		}

		return parent::beforeSet();
	}

}

return 'multiPollOfficeItemCreateProcessor';