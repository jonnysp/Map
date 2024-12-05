<?php
use Contao\DC_Table;
use Contao\Input;
use Contao\StringUtil;
use Contao\Image;
use Contao\System;
use Contao\DataContainer;
use Contao\Backend;

/**
 * Table tl_map_points
 */
$GLOBALS['TL_DCA']['tl_map_points'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => DC_Table::class, //	'Table',
		'ptable'                      => 'tl_map',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid,published' => 'index',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => DataContainer::MODE_SORTED,
			'fields'                  => array('title'),
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
			'panelLayout'             => 'filter;search,limit',
			'defaultSearchField'      => 'title'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
		),

		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		
		'operations' => array
		(

			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map_points']['toggle'],
				'icon'                => 'visible.svg',
				'href'                => 'act=toggle&amp;field=published',
				'button_callback'     => array('tl_map_points', 'toggleIcon')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title,published;{image_legend},image;{description_legend},info,description,position;'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => ['type' => 'integer','notnull' => false, 'unsigned' => true,'default' => '0','fixed' => true]
		),
		'title' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_map_points']['title'],
			'search'              	=> true,
			'inputType'          	=> 'text',
			'eval'                  => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'sql'                   => ['type' => 'string', 'length' => 128, 'default' => '']
		),
		'image' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map_points']['image'],
			'inputType'               => 'fileTree',
			// 'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes']),
		   'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>['jpg','jpeg','png']),
			'sql'                     => ['type' => 'binary','notnull' => false,'length' => 16,'fixed' => true]
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map_points']['description'],
			'inputType'               => 'textarea',
			'eval'                    => array('allowHtml'=>true, 'class'=>'monospace', 'rte'=>'ace|html', 'tl_class'=>'clr'),
			'sql'                     => "text NULL"
		),
		'info' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map_points']['info'],
			'inputType'               => 'checkbox',
			'isBoolean'				  => true,
			'eval'                    => array( 'tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'position' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map_points']['position'],
			'inputType'           	  => 'positionselectorfield',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'clr', 'nospace'=>false),
			'sql'					  => "varchar(128) NOT NULL default ''"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map_points']['toggle'],
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'w50'),
			'sql'                     => array('type' => 'boolean', 'default' => false)
		)
	)
);



class tl_map_points extends Backend{

	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
	
		$href .= '&amp;id=' . $row['id'];

		if (!$row['published'])
		{
			$icon = 'invisible.svg';
		}

      	return '<a href="' . $this->addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '" data-title="' . StringUtil::specialchars($title) . '" data-title-disabled="' . StringUtil::specialchars($title) . '" data-action="contao--scroll-offset#store" onclick="return AjaxRequest.toggleField(this,true)">' . Image::getHtml($icon, $label, 'data-icon="visible.svg" data-icon-disabled="invisible.svg" data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
	}
}

