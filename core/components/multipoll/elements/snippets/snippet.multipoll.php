<?php
/** @var array $scriptProperties */
/** @var multiPoll $multiPoll */
if (!$multiPoll = $modx->getService('multipoll', 'multiPoll', $modx->getOption('multipoll_core_path', null, $modx->getOption('core_path') . 'components/multipoll/') . 'model/multipoll/', $scriptProperties)) {
    return 'Could not load multiPoll class!';
}
// Параметры
$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.multiPoll.item');
$tplOption = $modx->getOption('tplOption', $scriptProperties, 'tpl.multiPoll.option');
$sortby = $modx->getOption('sortby', $scriptProperties, 'id');
$sortdir = $modx->getOption('sortbir', $scriptProperties, 'DESC');
$limit = $modx->getOption('limit', $scriptProperties, '1');
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

// Составляем запрос к базе
$c = $modx->newQuery('multiPollItem');
$c->sortby($sortby, $sortdir);
$c->limit(2); 
$c->leftJoin('multiPollOptionItem', 'multiPollOptionItem', 
    array('`multiPollItem`.`id` = `multiPollOptionItem`.`poll_id`')); // Джойним таблицу с вариантами ответов
$c->leftJoin('multiPollAnswerItem', 'multiPollAnswerItem', 
    array('`multiPollOptionItem`.`id` = `multiPollAnswerItem`.`option_id`')); // Джойним таблицу с голосами
$c->select('`multiPollItem`.`id`, 
            GROUP_CONCAT(`multiPollOptionItem`.`id`) as option_ids,
            COUNT(`multiPollAnswerItem`.`user_id`) as `votes`');
$c->groupby('`multiPollItem`.`id`');
$c->prepare();
$c->stmt->execute();
$items = $c->stmt->fetchAll(PDO::FETCH_ASSOC);

// Формируем плейсхолдеры
$list = array();
/** @var multiPollItem $item */
foreach ($items as $item) {
    $item['item_text'] = $modx->lexicon("multipoll_q_" . $item['id']); // Лексикон вопроса
    $options = array();
    $options = explode(",", $item['option_ids']);
    foreach ($options as $option_id) {
        $option['option_id'] = $option_id;
        $option['option_text'] = $modx->lexicon("multipoll_q_" . $item['id'] . "_o_" . $option_id); // Лексикон варианта ответа
        $item['options'][] = $modx->getChunk($tplOption, $option);
    }
    $item['options'] = implode($outputSeparator, $item['options']);
    $list[] = $modx->getChunk($tpl, $item);
}

// Output
$output = implode($outputSeparator, $list);
if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}
// Возвращаем $output
return $output;