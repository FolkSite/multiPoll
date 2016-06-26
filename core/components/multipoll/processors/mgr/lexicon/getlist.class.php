<?php
/**
 * 
 */
class multipollLexiconGetListProcessor extends modProcessor {
    public function checkPermissions() {
        return $this->modx->hasPermission('lexicons');
    }
    public function getLanguageTopics() {
        return array('lexicon');
    }

    public function initialize() {
        $this->setDefaultProperties(array(
            'start' => 0,
            'limit' => 10,
            'sort' => 'name',
            'dir' => 'ASC',
            'language' => 'en',
            'namespace' => 'core',
            'topic' => 'default',
        ));
        if ($this->getProperty('language') == '') $this->setProperty('language','en');
        if ($this->getProperty('namespace') == '') $this->setProperty('namespace','core');
        if ($this->getProperty('topic') == '') $this->setProperty('topic','default');
        return true;
    }

    public function process() {
    	$multipoll_q_ = 'multipoll_q_' . $this->getProperty('id');
        $where = array(
            'namespace' => $this->getProperty('namespace'),
            'topic' => $this->getProperty('topic'),
            'language' => $this->getProperty('language'),
            'name:LIKE' => '%'.$multipoll_q_.'%',
        );

        $search = $this->getProperty('search');
        if (!empty($search)) {
            $where[] = array(
                'name:LIKE' => '%'.$search.'%',
                'OR:value:LIKE' => '%'.$search.'%',
            );
        }

        /* setup query for db based lexicons */
        $c = $this->modx->newQuery('modLexiconEntry');
        $c->where($where);
        $c->sortby('name','ASC');
        $results = $this->modx->getCollection('modLexiconEntry',$c);
        
        $dbEntries = array();
        /** @var modLexiconEntry $r */
        foreach ($results as $r) {
            $dbEntries[$r->get('name')] = $r->toArray();
        }

        /* first get file-based lexicon */
        $entries = $this->modx->lexicon->getFileTopic($this->getProperty('language'),$this->getProperty('namespace'),$this->getProperty('topic'));
        $entries = is_array($entries) ? $entries : array();

        /* if searching */
        if (!empty($search)) {
            function parseArray($needle,array $haystack = array()) {
                if (!is_array($haystack)) return false;
                $results = array();
                foreach($haystack as $key=>$value) {
                    if (strpos($key, $needle)!==false || strpos($value,$needle) !== false) {
                        $results[$key] = $value;
                    }
                }
                return $results;
            }

            $entries = parseArray($search,$entries);
        }

        /* add in unique entries */
        $es = array_diff(array_keys($dbEntries),array_keys($entries));
        foreach ($es as $n) {
            $entries[$n] = $dbEntries[$n]['value'];
        }
        $count = count($entries);
        ksort($entries);
        $entries = array_slice($entries,$this->getProperty('start'),$this->getProperty('limit'),true);

        /* loop through */
        $list = array();
        foreach ($entries as $name => $value) {
            $entryArray = array(
                'name' => $name,
                'value' => $value,
                'namespace' => $this->getProperty('namespace'),
                'topic' => $this->getProperty('topic'),
                'language' => $this->getProperty('language'),
                'createdon' => null,
                'editedon' => null,
                'overridden' => 0,
            );
            /* if override in db, load */
            if (array_key_exists($name,$dbEntries)) {
                $entryArray = array_merge($entryArray,$dbEntries[$name]);

                $entryArray['editedon'] = strtotime($entryArray['editedon']) ? strtotime($entryArray['editedon']) : strtotime($entryArray['createdon']);

                $entryArray['overridden'] = 1;
            }
            $list[] = $entryArray;
        }
        
        return $this->outputArray($list,$count);
    }
}
return 'multipollLexiconGetListProcessor';