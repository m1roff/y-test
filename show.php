<?php
/**
 * Вырисовка картинки.
 * Над выводом ошибок не работал.
 */
include_once(dirname(__FILE__).'/lib/aGraph.php');

$_mayPrint = array(
    'circle' => array(
        'className' => 'CircleGraph',
        'classFile' => dirname(__FILE__).'/lib/CircleGraph.php'
    ),
    'square' => array(
        'className' => 'SquareGraph',
        'classFile' => dirname(__FILE__).'/lib/SquareGraph.php'
    ),
);

$_type   = isset($_GET['type']) ? $_GET['type'] : null;
$_params = isset($_GET['params']) ? $_GET['params'] : null;

if ( $_type===null || $_params === null )
{
    Graph::showErrorMessage('Failed to get the data.');
}
elseif(!isset($_mayPrint[$_type]))
{
    Graph::showErrorMessage('Impossible to draw this figure. This shape is not defined.');
}
else
{
    include($_mayPrint[$_type]['classFile']);
    $gr = new $_mayPrint[$_type]['className'];
    $gr->params = $_params;
    $gr->show();
}