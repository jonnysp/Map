<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2019 Jonny Spitzner
 *
 * @license LGPL-3.0+
 */



Contao\ArrayUtil::arrayInsert($GLOBALS['BE_MOD']['map'], 100, array
(
	'map' 		=> array('tables' => array('tl_map', 'tl_map_points'))
));


/**
 * Style sheet
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/jonnyspmap/map.css|static';
	$GLOBALS['BE_FFL']['positionselectorfield'] = 'PositionSelectorField';
}
 */

// das Konstrukt 
// if (TL_MODE === 'BE')
// kann durch folgende Zeilen ersetzt werden

use Contao\System;
use Symfony\Component\HttpFoundation\Request;
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
Contao\ArrayUtil::arrayInsert($GLOBALS['TL_CTE'], 1, array
	(
		'includes' 	=> array
			(
				'map_viewer'	=> 'MapViewer'
			)
	)
);


