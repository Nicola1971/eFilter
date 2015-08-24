<?php
$settings['display'] = 'vertical';
$settings['fields'] = array(
	'param_id' => array(
        'caption' => '<b>parametro</b>',
        'type' => 'dropdown',
        'elements' => '@EVAL return $modx->runSnippet("multiParams", array("action"=>"getParamsToMultiTV"));'
    ),
	'cat_name' => array(
        'caption' => 'Categoria',
        'type' => 'text'
    ),
	'list_yes' => array(
        'caption' => 'In lista',
        'type' => 'checkbox',
        'elements' => 'si==1'
    ),
    'fltr_yes' => array(
        'caption' => 'Filtro',
        'type' => 'checkbox',
        'elements' => 'si==1'
    ),
    'fltr_type' => array(
        'caption' => 'Tipo di filtro',
        'type' => 'dropdown',
        'elements' => '||checkbox==1||list==2||range==3||select==4||multiselect==5||slider==6||color==7||pattern==8'
    ),
    'fltr_name' => array(
        'caption' => 'Titolo del filtro',
        'type' => 'text'
    ),
	'fltr_many' => array(
        'caption' => 'Multiplo',
        'type' => 'checkbox',
        'elements' => 'si==1'
    ),
	'param_choose' => array(
        'caption' => 'Selezione parametri',
        'type' => 'checkbox',
        'elements' => 'si==1'
    )
);
$settings['templates'] = array(
    'outerTpl' => '[+wrapper+]',
    'rowTpl' => '[+element+]'
);
$settings['configuration'] = array(
    'enablePaste' => false,
    'enableClear' => true
);