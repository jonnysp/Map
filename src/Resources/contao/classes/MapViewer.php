<?php

use Map\Model\MapModel;
use Map\Model\MapPointsModel;
use Contao\ContentElement;
use Contao\BackendTemplate;
use Contao\File;
use Contao\System;	// siehe config.php
use Symfony\Component\HttpFoundation\Request;

class MapViewer extends ContentElement
{
	protected $strTemplate = 'ce_mapviewer';

	public function generate()
	{
		//	if (TL_MODE == 'BE')	// siehe config.php
		if (System::getContainer()->get('contao.routing.scope_matcher')
			->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))
		) {
			$objMap = MapModel::findByPK($this->map);
			// $objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate = new BackendTemplate('be_wildcard');
			// $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['tl_content']['map_legend']) . ' ###';
			$objTemplate->wildcard = '### ' . strtoupper($GLOBALS['TL_LANG']['tl_content']['map_legend']) . ' ###';
			$objTemplate->title = '[' . $objMap->id . '] - ' . $objMap->title;
			return $objTemplate->parse();
		}
		return parent::generate();
	} //end generate

	protected function compile()
	{

		$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/jonnyspmap/leaflet.js';
		$GLOBALS['TL_CSS'][] = 		  'bundles/jonnyspmap/leaflet.css';

		global $objPage;
		$this->loadLanguageFile('tl_map');
		$this->loadLanguageFile('tl_map_points');

		//gets the categorie
		$objMap = MapModel::findByPK($this->map);

		try {
			$mapposition = unserialize($objMap->position);
		} catch (Exception $e) {
			$mapposition = array();
		}

		$Map = array(
			"id" => $objMap->id,
			"titleURL" => $objMap->titleURL,
			"copyright" => $objMap->copyright,
			"title" => $objMap->title,
			"description" => $objMap->description,
			"height" => $objMap->height,
			"latitude" => $mapposition[0],
			"longitude"  => $mapposition[1],
			"zoom"  => $mapposition[2],
			"autozoom" => boolval($objMap->autozoom),
			"mousescroll" => boolval($objMap->mousescroll),
			"minzoom" => $objMap->minzoom,
			"maxzoom" => $objMap->maxzoom
		);

		$this->Template->Map = $Map;

		$filter = array('column' => array('pid=?', 'published=?'), 'value' => array($objMap->id, 1));
		$objPoints = MapPointsModel::findAll($filter);

		$points = array();


		foreach ($objPoints as $key => $value) {

			try {
				$position = unserialize($value->position);
			} catch (Exception $e) {
				$position = array();
			}


			if (isset($value->image)) {

				$imagemodel = \FilesModel::findByPk($value->image);
				$objFile = new File($imagemodel->path);

				$points[$key] = array(
					"title" => $value->title,
					"image" => $imagemodel->path,
					"size" => $objFile->imageSize,
					"latitude"  => $position[0],
					"longitude"  => $position[1],
					"zoom"  => $position[2],
					"description" =>  $value->description,
					"info" => boolval($value->info)
				);
			} else {

				$points[$key] = array(
					"title" => $value->title,
					"image" => NULL,
					"size" => NULL,
					"latitude"  => $position[0],
					"longitude"  => $position[1],
					"zoom"  => $position[2],
					"description" =>  $value->description,
					"info" => boolval($value->info)
				);
			}
		}

		$this->Template->Points = $points;
	} //end compile

}//end class
