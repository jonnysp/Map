<?php

class PositionSelectorField extends Widget
{

	protected $strTemplate = 'be_widget';
	protected $blnSubmitInput = true;	

	public function generate()
	{
		
		$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/jonnyspmap/leaflet.js';
		$GLOBALS['TL_CSS'][] = 		  'bundles/jonnyspmap/leaflet.css';

		$olmapname = 'olmap'.$this->__get('currentRecord');

		echo  '<div class="tl_text" id="'.$olmapname .'_canvas" style="width:auto; height:300px;"></div>

				<script type="text/javascript">
					
					var '.$olmapname.'default_zoom = 3;
					var '.$olmapname.'min_zoom = 1;
					var '.$olmapname.'max_zoom = 19;
					var '.$olmapname.'marker = {};
					var '.$olmapname.'markerpos = ['.(isset($this->varValue[0]) ? $this->varValue[0] : 0).' ,'.(isset($this->varValue[1]) ? $this->varValue[1] : 0).'];
					var '.$olmapname.'markerzoom = '.(isset($this->varValue[2]) ? $this->varValue[2] : 5).';

					var markerIcon = L.icon({
					    iconUrl: "bundles/jonnyspmap/images/marker-icon.png",
					    iconSize:     [25,41], 
					    iconAnchor:   [12, 41], 
					    popupAnchor:  [1, -30] 
					});

					function onZoomed(e){
						'.$olmapname.'markerzoom = '.$olmapname.'.getZoom();
					//	'.$olmapname.'.flyTo('.$olmapname.'markerpos,'.$olmapname.'markerzoom);
						document.getElementById("ctrl_'.$this->strId.'_2").set("value",'.$olmapname.'markerzoom);
					}

					function onMapClick(e) {

						'.$olmapname.'markerpos  = e.latlng;
						'.$olmapname.'markerzoom = '.$olmapname.'.getZoom();

						document.getElementById("ctrl_'.$this->strId.'_0").set("value",e.latlng.lat);
						document.getElementById("ctrl_'.$this->strId.'_1").set("value",e.latlng.lng);

							if ('.$olmapname.'marker  != undefined) {
								'.$olmapname.'.removeLayer('.$olmapname.'marker);
							};

						'.$olmapname.'marker = L.marker(e.latlng, {icon: markerIcon }).addTo('.$olmapname.');
						'.$olmapname.'.flyTo('.$olmapname.'markerpos,'.$olmapname.'markerzoom);
					}

					function '.$olmapname.'initialize() {

						'.$olmapname.' = L.map('.$olmapname .'_canvas).setView([0, 0], '.$olmapname.'default_zoom);

						L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
							maxZoom: '.$olmapname.'max_zoom,
							minZoom: '.$olmapname.'min_zoom,
						}).addTo('.$olmapname.');

						'.$olmapname.'marker = L.marker('.$olmapname.'markerpos, {icon: markerIcon }).addTo('.$olmapname.');
						'.$olmapname.'.flyTo('.$olmapname.'markerpos,'.$olmapname.'markerzoom)

						'.$olmapname.'.on("zoomend", onZoomed );
						'.$olmapname.'.on("click", onMapClick);

					}

					window.addEvent("domready", function() {
						'.$olmapname.'initialize();
					});					

			</script>';


		if (!is_array($this->varValue))
		{
			$this->varValue = array($this->varValue);
		}


		$arrFields = array();

		for ($i=0; $i<3; $i++)
		{
			$arrFields[] = sprintf('<input type="text" name="%s[]" id="ctrl_%s" class="tl_text_3" value="%s" %s onfocus="Backend.getScrollOffset()">',
									$this->strName,
									$this->strId.'_'.$i,
									specialchars(@$this->varValue[$i]), // see #4979
									$this->getAttributes());
		}


		return sprintf('<div id="ctrl_%s"%s>%s</div>%s',
						$this->strId,
						(($this->strClass != '') ? ' class="' . $this->strClass . '"' : ''),
						implode(' ', $arrFields),
						$this->wizard);

	}
}