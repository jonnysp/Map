<?php

class MapViewer extends ContentElement
{
	protected $strTemplate = 'ce_mapviewer';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objMap = \MapModel::findByPK($this->map);
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['tl_content']['map_legend']) . ' ###';
			$objTemplate->title = '['. $objMap->id.'] - '. $objMap->title;
			return $objTemplate->parse();	
		}
		return parent::generate();
	}//end generate

	protected function compile()
	{

		global $objPage;
		$this->loadLanguageFile('tl_map');
		$this->loadLanguageFile('tl_map_points');

		//gets the categorie
		$objMap = \MapModel::findByPK($this->map);

		if(isset($objMap->api_key)){
			$GLOBALS['TL_JAVASCRIPT'][] = '//maps.google.com/maps/api/js?key='.$objMap->api_key.'&amp;sensor=false&amp;language='.$objPage->language;
		}else{
			$GLOBALS['TL_JAVASCRIPT'][] = '//maps.google.com/maps/api/js?sensor=false&amp;language='.$objPage->language;
		}

		try
		{
			$mapposition = unserialize($objMap->position);
		}
		catch (Exception $e)
		{
			$mapposition = array();
		}

		$Map= array(
			id => $objMap->id,
			title => $objMap->title,
			description => $objMap->description,
			api_key => $objMap->api_key,
			height => $objMap->height,
			maptype => $objMap->maptype,
			stylearray => $objMap->stylearray,
			latitude  => $mapposition[0],
			longitude  => $mapposition[1],
			zoom  => $mapposition[2],
			autozoom => $objMap->autozoom
		);

		$this->Template->Map = $Map;

		$filter = array('column' => array('pid=?','published=?'),'value' => array($objMap->id,1));
		$objPoints = \MapPointsModel::findAll($filter);

		$points = array();	


		foreach ($objPoints as $key => $value) {

			try
			{
				$position = unserialize($value->position);
			}
			catch (Exception $e)
			{
				$position = array();
			}

			$points[$key] = array(
				title => $value->title,
				image => \FilesModel::findByPk($value->image)->path,
				latitude  => $position[0],
				longitude  => $position[1],
				description =>  $value->description,
				info => boolval($value->info)
			);
		}
		







//		//get Recipes data
//		if (count($filterRecipes) > 0){
//			foreach ($filterRecipes as $key => $value) {
//
//				//main Image
//				
//				
//				//additional sorted Images
//				$RecipeImages = array();
//				$RecipeUnsortedImages = \FilesModel::findMultipleByUuids(StringUtil::deserialize($value->images));
//				$RecipeImagesSort = StringUtil::deserialize($value->imagessort);
//
//		 		if ($RecipeImagesSort){
//		 			foreach ($RecipeImagesSort as $sortkey => $uuid) {
//						if ($RecipeUnsortedImages){
//							foreach ($RecipeUnsortedImages as $Image) {
//								if ($Image->uuid == $uuid) {
//									array_push($RecipeImages, array
//										(
//											meta => $this->getMetaData($Image->meta, $objPage->language),
//											path => $Image->path,
//											name => $Image->name,
//											extension => $Image->extension
//										)
//									);
//								}
//							}
//						}
//		 			}
//				}
//
//				// generate Data_array
//				$Recipes[$key] = array(
//					id => $value->id,
//					title => $value->title,
//					description => $value->description,
//					ingredients => $value->ingredients,
//					preparation => $value->preparation,
//					published => $value->published,
//					tags => StringUtil::deserialize($value->tags),
//					categories => StringUtil::deserialize($value->categories),
//					image =>  array(
//							meta => $this->getMetaData($RecipeImage->meta, $objPage->language),
//							path => $RecipeImage->path,
//							name => $RecipeImage->name,
//							extension => $RecipeImage->extension
//							),
//					images => $RecipeImages
//				);
//			}
//		}


		$this->Template->Points = $points;
//		$this->Template->Recipes = $Recipes;

	}//end compile

}//end class
