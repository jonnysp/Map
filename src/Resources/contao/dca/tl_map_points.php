<?php

use Contao\DC_Table;
use Contao\DataContainer;

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
		'markAsCopy'                  => 'title',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid,published' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => DataContainer::MODE_PARENT,
			'fields'                  => array('title'),
			'headerFields'            => array('title', 'tstamp'),
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
			'panelLayout'             => 'filter;search,limit',
			'defaultSearchField'      => 'title'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
		),
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
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'%contao.image.valid_extensions%'),
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
			'sql'					  =>"varchar(128) NOT NULL default 'a:3:{i:0;s:1:\"0\";i:1;s:1:\"0\";i:2;s:1:\"1\";}'"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map_points']['toggle'],
			'toggle'                  => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'w50 m12'),
			'sql'                     => array('type' => 'boolean', 'default' => false)
		)
	)
);
