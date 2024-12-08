<?php

use Contao\ContentElement;
use Contao\BackendTemplate;
use Contao\StringUtil;
use Contao\System;
use Contao\FilesModel;
use Contao\File;
use Map\Model\MapModel;
use Map\Model\MapPointsModel;

class MapViewer extends ContentElement
{
	protected $strTemplate = 'ce_mapviewer';

	public function generate(): string
	{
		$request = System::getContainer()->get('request_stack')->getCurrentRequest();

		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$objMap = MapModel::findByPK($this->map);
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['tl_content']['map_legend'] . ' ###';

			if (null !== $objMap)
			{
				$objTemplate->title = '['. $objMap->id.'] - '. $objMap->title;
			}	

			return $objTemplate->parse();
		}

		return parent::generate();
	}

	protected function compile(): void
	{
		$points = array();

		$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/jonnyspmap/leaflet.js';
		$GLOBALS['TL_CSS'][] = 		  'bundles/jonnyspmap/leaflet.css';

		$this->loadLanguageFile('tl_map');
		$this->loadLanguageFile('tl_map_points');

		// Get the category and return early when no map was found
		if (null === ($objMap = MapModel::findByPK($this->map)))
		{
			$this->Template->Points = $points;

			return;
		}

		$mapPosition = StringUtil::deserialize($objMap->position, true);

		$lat = isset($mapPosition[0]) && '' !== $mapPosition[0] ? $mapPosition[0] : 0;
		$lng = isset($mapPosition[1]) && '' !== $mapPosition[1] ? $mapPosition[1] : 0;
		$zoom = isset($mapPosition[2]) && '' !== $mapPosition[2] ? $mapPosition[2] : 5;

		$Map = array(
			"id" => $objMap->id,
			"titleURL" => $objMap->titleURL,
			"copyright" => $objMap->copyright,
			"title" => $objMap->title,
			"description" => $objMap->description,
			"height" => $objMap->height,
			"latitude" => $lat,
			"longitude" => $lng,
			"zoom" => $zoom,
			"autozoom" => boolval($objMap->autozoom),
			"mousescroll" => boolval($objMap->mousescroll),
			"minzoom" => $objMap->minzoom,
			"maxzoom" => $objMap->maxzoom
		);

		$this->Template->Map = $Map;

		$filter = array('column' => array('pid=?','published=?'),'value' => array($objMap->id,1));
		$objPoints = MapPointsModel::findAll($filter);

		if (null !== $objPoints)
		{
			foreach ($objPoints as $key => $value)
			{
				try
				{
					$position = unserialize($value->position);
				}
				catch (Exception $e)
				{
					$position = array();
				}


				if (isset($value->image)) {

					$imagemodel = FilesModel::findByPk($value->image);
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

				}else{

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
		}

		$this->Template->Points = $points;
	}
}
