<?php

use Contao\System;
use Contao\Backend;
use Map\Model\MapModel;
use Contao\DataContainer;
use Contao\StringUtil;
use Contao\Image;

$GLOBALS['TL_DCA']['tl_content']['palettes']['map_viewer'] = '{type_legend},type;{map_legend},map;{protected_legend:hide};{expert_legend:hide},cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['fields']['map'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['map'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_map', 'getMap'),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true),
	'wizard' 				  => array(array('tl_content_map', 'editMap')),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

class tl_content_map extends Backend 
{

	public function getMap()
	{
		$objMaps = MapModel::findAll();
		$arrMaps = array();
		foreach ($objMaps as $objMap)
		{
			$arrMaps[$objMap->id] = '[ID ' . $objMap->id . '] - '. $objMap->title;
		}
		return $arrMaps;
	}

	public function editMap(DataContainer $dc)
	{
		$this->loadLanguageFile('tl_map');

		$title = sprintf($GLOBALS['TL_LANG']['tl_map']['editheader'][1], $dc->value);
		$href = System::getContainer()->get('router')->generate('contao_backend', array('do'=>'map', 'table'=>'tl_map','act'=>'edit', 'id'=>$dc->value , 'popup'=>'1', 'nb'=>'1'));
		return ' <a href="' . StringUtil::specialcharsUrl($href) . '" title="' . StringUtil::specialchars($title) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", $title)) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $title) . '</a>';
	}

}