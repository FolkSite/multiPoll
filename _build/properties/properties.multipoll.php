<?php

$properties = array();

$tmp = array(
	'tpl' => array(
		'type' => 'textfield',
		'value' => 'tpl.multiPoll.item',
	),
	'tplOption' => array(
		'type' => 'textfield',
		'value' => 'tpl.multiPoll.option',
	),
	'sortby' => array(
		'type' => 'textfield',
		'value' => 'id',
	),
	'sortdir' => array(
		'type' => 'list',
		'options' => array(
			array('text' => 'ASC', 'value' => 'ASC'),
			array('text' => 'DESC', 'value' => 'DESC'),
		),
		'value' => 'DESC'
	),
	'limit' => array(
		'type' => 'numberfield',
		'value' => 1,
	),
	'outputSeparator' => array(
		'type' => 'textfield',
		'value' => "\n",
	),
	'toPlaceholder' => array(
		'type' => 'combo-boolean',
		'value' => false,
	),
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;