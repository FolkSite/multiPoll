<?php
// >> Подключаем MODx
define('MODX_API_MODE', true);
$current_dir = dirname(__FILE__) .'/';
$index_php = $current_dir .'index.php';
$i=0;
while( !file_exists( $index_php ) && $i < 9 )
{
	$current_dir = dirname(dirname($index_php)) .'/';
	$index_php = $current_dir .'index.php';
	$i++;
}
if( file_exists($index_php) )
{
	require_once $index_php;
}
else {
	print "Error. Dont require MODX."; die;
}
// << Подключаем MODx

if (!$multiPoll = $modx->getService('multipoll', 'multiPoll', $modx->getOption('multipoll_core_path', null, $modx->getOption('core_path') . 'components/multipoll/') . 'model/multipoll/', $scriptProperties)) {
    return 'Could not load multiPoll class!';
}

$option_id = $_REQUEST['option_id'];
echo $option_id;