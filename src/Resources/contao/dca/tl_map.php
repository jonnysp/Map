<?php
use Contao\DC_Table;

/**
 * Table tl_map
 */
$GLOBALS['TL_DCA']['tl_map'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => DC_Table::class,
		'ctable'                      => array('tl_map_points'),
		'markAsCopy'                  => 'title',
		'enableVersioning'            => true,
		 'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),


	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('id','title'),
			'format'                  => '[%s] - %s'
		),
	),


// Palettes
	'palettes' => array
	(
		'default'       => '{title_legend},title,height,titleURL,copyright;{zoom_legend},autozoom,minzoom,maxzoom,mousescroll;{description_legend},description;{position_legend},position;'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['title'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w50 clr'),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'titleURL' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['titleURL'],
			'default'				  => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>128, 'tl_class'=>'w100 clr'),
			'sql'                     => "varchar(128) NOT NULL default 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'"
		),
		'copyright' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['copyright'],
			'default'				  => '',
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'allowHtml'=>true,'preserveTags'=>true,'maxlength'=>128, 'tl_class'=>'w100 clr'),
			'sql'                     => "text NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['description'],
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE'),
			'sql'                     => "text NULL"
		),
		'height' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['height'],
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50 clr'),
			'sql'                     => "varchar(128)  NOT NULL default '400px'"
		),
		'position' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['position'],
			'inputType'           	  => 'positionselectorfield',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'clr', 'nospace'=>false),
			'sql'					  => "varchar(128) NOT NULL default 'a:3:{i:0;s:1:\"0\";i:1;s:1:\"0\";i:2;s:1:\"1\";}'"
		),
		'autozoom' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['autozoom'],
			'inputType'               => 'checkbox',
			'isBoolean'				  => true,
			'eval'                    => array( 'tl_class'=>'w100 clr'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'mousescroll' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['mousescroll'],
			'inputType'               => 'checkbox',
			'isBoolean'				  => true,
			'eval'                    => array( 'tl_class'=>'w100 clr'),
			'sql'                     => "char(1) NOT NULL default '1'"
		),
		'minzoom' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['minzoom'],
			'default'				  => 1,
			'inputType'               => 'text',
			'eval'                    => array( 'tl_class'=>'w50','rgxp'=>'natural'),
			'sql'                     => "int(10) NOT NULL default '1'"
		),
		'maxzoom' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['maxzoom'],
			'default'				  => 19,
			'inputType'               => 'text',
			'eval'                    => array( 'tl_class'=>'w50','rgxp'=>'natural'),
			'sql'                     => "int(10) NOT NULL default '19'"
		)
	)
);


