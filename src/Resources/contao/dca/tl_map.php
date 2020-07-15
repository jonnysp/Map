<?php

/**
 * Table tl_map
 */
$GLOBALS['TL_DCA']['tl_map'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_map_points'),
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
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map']['edit'],
				'href'                => 'table=tl_map_points',
				'icon'                => 'edit.svg'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.svg'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
	),


// Palettes
	'palettes' => array
	(
		'__selector__'  => array('maptype'),
		'default'       => '{title_legend},title,api_key,height,maptype,autozoom;{description_legend},description,position;',
		'user'          => '{title_legend},title,api_key,height,maptype,stylearray,autozoom;{description_legend},description,position;'
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
		'api_key' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['api_key'],
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>128, 'tl_class'=>'w50'),
			'sql'                     => "varchar(128) NOT NULL default ''"
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
			'eval'                    => array('tl_class'=>'clr'),
			'sql'                     => "varchar(128)  NOT NULL default '400px'"
		),
		'maptype' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_map']['maptype'],
            'inputType'               => 'select',
            'sorting'                 => true,
            'flag'                    => 1,
            'options'                 => array('user','roadmap','satellite','hybrid','terrain'),
            'reference'               => &$GLOBALS['TL_LANG']['tl_map'],
            'eval'                    => array('includeBlankOption' => false,'submitOnChange' => true,'tl_class'=> 'w50'),                
            'sql'                     => "varchar(128) NOT NULL default 'roadmap'"
        ),
		'stylearray' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['stylearray'],
			'inputType'               => 'textarea',
			'eval'                    => array('allowHtml'=>true, 'class'=>'monospace', 'rte'=>'ace|html', 'tl_class'=>'clr'),
			'sql'                     => "text NULL"
		),
		'position' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['position'],
			'inputType'           	  => 'positionselectorfield',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'clr', 'nospace'=>false),
			'sql'					  => "varchar(128) NOT NULL default ''"
		),
		'autozoom' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_map']['autozoom'],
			'inputType'               => 'checkbox',
			'isBoolean'				  => true,
			'eval'                    => array( 'tl_class'=>'w50'),
			'sql'                     => "char(1) NOT NULL default ''"
		)

	)
);


