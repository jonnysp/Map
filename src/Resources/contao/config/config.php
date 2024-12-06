<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2019 Jonny Spitzner
 *
 * @license LGPL-3.0+
 */


use Map\Model\MapModel;
use Map\Model\MapPointsModel;
use Contao\ArrayUtil;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;

$GLOBALS['TL_MODELS']['tl_map'] = MapModel::class;
$GLOBALS['TL_MODELS']['tl_map_points'] = MapPointsModel::class;

ArrayUtil::arrayInsert($GLOBALS['BE_MOD']['map'], 100, array
(
	'map' 		=> array('tables' => array('tl_map', 'tl_map_points'))
));


/**
 * Style sheet
 */
if (System::getContainer()->get('contao.routing.scope_matcher')
	->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))
)  
{
	$GLOBALS['TL_CSS'][] = 'bundles/jonnyspmap/map.css|static';
	$GLOBALS['BE_FFL']['positionselectorfield'] = 'PositionSelectorField';
}

/**
 * Front end modules
 */
ArrayUtil::arrayInsert($GLOBALS['TL_CTE'], 1, array
	(
		'includes' 	=> array
			(
				'map_viewer'	=> 'MapViewer'
			)
	)
);


