<?php

$params = array(
    array(
        'type'   => 'circle', 
        'params' =>array(
            'radius' => 20,
        )
    ),
    array(
        'type'   => 'square', 
        'params' =>array(
            'size' => 21,
        )
    ),
    array(
        'type'   => 'square', 
        'params' =>array(
            'size' => 150,
        )
    ),
    array(
        'type'   => 'circle', 
        'params' =>array(
            'radius' => 100,
        )
    ),
);




for($i=0, $max=count($params); $i<$max; ++$i)
{
    ?>
    <h3>Type:<?=$params[$i]['type']?></h3>
    <img src="/show.php?<?=http_build_query($params[$i])?>" />
    <hr>
    <?
}