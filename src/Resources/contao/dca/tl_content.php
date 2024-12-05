<?php
use Contao\System;
use Contao\Backend;
use Contao\Model;
use Map\MapModel;
use Contao\DataContainer;
use Contao\StringUtil;
use Contao\Image;

// $GLOBALS['TL_DCA']['tl_content']['palettes']['map_viewer'] = '{type_legend},type;{map_legend},map;{protected_legend:hide},protected;{expert_legend:hide},cssID,space;{invisible_legend:hide},invisible,start,stop';
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
		$objCats =  Map\Model\MapModel::findAll();
		$arrCats = array();
		foreach ($objCats as $objCat)
		{
			$arrCats[$objCat->id] = '[ID ' . $objCat->id . '] - '. $objCat->title;
		}
		return $arrCats;
	}

	public function editMap(DataContainer $dc)
	{
		$requestToken = System::getContainer()->get('contao.csrf.token_manager')->getDefaultTokenValue();
		$this->loadLanguageFile('tl_map');
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=map&amp;act=edit&amp;id=' . $dc->value . '&amp;popup=1&amp;nb=1&amp;rt=' . $requestToken . '" title="' . sprintf(StringUtil::specialchars($GLOBALS['TL_LANG']['tl_map']['editheader'][1]), $dc->value) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", sprintf($GLOBALS['TL_LANG']['tl_map']['editheader'][1], $dc->value))) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $GLOBALS['TL_LANG']['tl_map']['editheader'][0]) . '</a>';
	}

}