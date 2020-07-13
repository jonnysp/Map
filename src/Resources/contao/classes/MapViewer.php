<?php

class MapViewer extends ContentElement
{
	protected $strTemplate = 'ce_mapviewer';

	public function generate()
	{
//		if (TL_MODE == 'BE')
//		{
//			$objCat = \MapModel::findByPK($this->map);
//			$objTemplate = new \BackendTemplate('be_wildcard');
//			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['tl_content']['map_legend']) . ' ###';
//			$objTemplate->title = '['. $objCat->id.'] - '. $objCat->title;
//			return $objTemplate->parse();	
		}
		return parent::generate();
	}//end generate

	protected function compile()
	{
//		global $objPage;
//		$this->loadLanguageFile('tl_recipes');
//		$this->loadLanguageFile('tl_recipes_categories');
//
//		//gets the categorie
//		$objCategorie = \RecipesCategoriesModel::findByPK($this->recipescategorie);
//		
//		$Recipes = array();
//
//		$filterRecipes = \RecipesModel::findAll(
//			array('column' => array('pid=?','published=?'),'value' => array($this->recipescategorie,1) ,'order' => 'sorting')
//		);
//
//		//get Categorie data
//		$CategorieImage = \FilesModel::findByPk($objCategorie->image);
//		$Categorie = array(
//			id => $objCategorie->id,
//			title => $objCategorie->title,
//			description => $objCategorie->description,
//			image => array(
//					meta => $this->getMetaData($CategorieImage->meta, $objPage->language),
//					path => $CategorieImage->path,
//					name => $CategorieImage->name,
//					extension => $CategorieImage->extension
//				)
//		);
//
//		//get Recipes data
//		if (count($filterRecipes) > 0){
//			foreach ($filterRecipes as $key => $value) {
//
//				//main Image
//				$RecipeImage = \FilesModel::findByPk($value->image);
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
//
//		$this->Template->RecipesCategorie = $Categorie;
//		$this->Template->Recipes = $Recipes;

	}//end compile

}//end class
