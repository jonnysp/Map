<?php
use Contao\DC_Table;
use Contao\Input;
use Contao\StringUtil;
use Contao\Image;
use Contao\CoreBundle\Security\ContaoCorePermissions;
use Contao\System;

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
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'headerFields'            => array('title'),
			'flag'        			  => 1,
			'panelLayout'             => 'filter;search,limit',
			'child_record_callback'   => array('tl_map_points', 'generateReferenzRow')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_map_points']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg'
			),

			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map_points']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map_points']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map_points']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? '') . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_map_points']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			),
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

use Contao\Image\ResizeConfiguration;

use Contao\Backend;

class tl_map_points extends Backend{

	public function generateReferenzRow($arrRow)	{
		$this->loadLanguageFile('tl_map_points');

		$label = $arrRow['title'];

//		if ($arrRow['image'] != '')
//		{
//			$objFile = FilesModel::findByUuid($arrRow['image']);
//			if ($objFile !== null)
//			{
//				$container = System::getContainer();
//				$rootDir = $container->getParameter('kernel.project_dir');
//
//				$label = Image::getHtml($container->get('contao.image.image_factory')->create($rootDir.'/'.$objFile->path,(new ResizeConfiguration())->setWidth(80)->setHeight(80)->setMode(ResizeConfiguration::MODE_BOX))->getUrl($rootDir), '', 'style="float:left;"') . ' ' . $label;
//
//			}
//		}
		return $label;
    }


	public function setFileTreeFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord)
		{
				$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
		}
		return $varValue;
	}


	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{

		$security = System::getContainer()->get('security.helper');

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$security->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELD_OF_TABLE, 'tl_map_points::published'))
		{
			return '';
		}

		$href .= '&amp;id=' . $row['id'];

		if (!$row['published'])
		{
			$icon = 'invisible.svg';
		}

        return '<a href="'.$this->addToUrl($href).'" title="'.StringUtil::specialchars($title) . '" data-title="' . StringUtil::specialchars($title) . '" data-title-disabled="' . StringUtil::specialchars($title) . '" data-action="contao--scroll-offset#store" onclick="return AjaxRequest.toggleField(this,true)">' . Image::getHtml($icon, $label, 'data-icon="visible.svg" data-icon-disabled="invisible.svg" data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';

	}


}

