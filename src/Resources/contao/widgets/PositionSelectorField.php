<?php

class PositionSelectorField extends Widget
{


	protected $strTemplate = 'be_widget';
	protected $blnSubmitInput = true;	
 

	public function generate()
	{
	
		$GLOBALS['TL_JAVASCRIPT'][] = '//maps.google.com/maps/api/js?sensor=false&amp;language=de';
		

		$mapname = 'map'.$this->__get('currentRecord');
	
	
		$map .= '<script type="text/javascript">
						 

						window.addEvent("domready", function() {
								'.$mapname.'initialize();
						});
								
						var '.$mapname.';		
						var '.$mapname.'geocoder;
						var '.$mapname.'markers = [];
						var '.$mapname.'_lat;
						var '.$mapname.'_lng;
						var '.$mapname.'_zoom;
					
						var '.$mapname.'_search;
						var '.$mapname.'_searchaction;


						function '.$mapname.'codeAddress() {
							var address = '.$mapname.'_search.value;
							
							if ('.$mapname.'geocoder) {
								
								'.$mapname.'geocoder.geocode( { "address": address}, function(results, status) {

									if (status == google.maps.GeocoderStatus.OK) {
										
									'.$mapname.'.setCenter(results[0].geometry.location);
									
									for (var i = 0; i < '.$mapname.'markers.length; i++) {
										'.$mapname.'markers[i].setMap(null);
						   			}

									var marker = new google.maps.Marker({
										position: results[0].geometry.location,
										map: '.$mapname.'
									});
									'.$mapname.'markers.push(marker);

									'.$mapname.'_lat.value = results[0].geometry.location.lat();
									'.$mapname.'_lng.value = results[0].geometry.location.lng();

									} else {
										alert("Geocode was not successful for the following reason: " + status);
									}

								});
							}
							
						};

						function '.$mapname .'initialize() {
	
							var myOptions = {
								zoom: 2,
								center: new google.maps.LatLng(30, 0),
								mapTypeId: google.maps.MapTypeId.TERRAIN,
								disableDefaultUI: true
							}
							
							'.$mapname.'geocoder = new google.maps.Geocoder();
							'.$mapname.' = new google.maps.Map(document.getElementById("'.$mapname .'_canvas"), myOptions);
							'.$mapname.'_lat = document.getElementById("ctrl_'.$this->strId.'_0");
							'.$mapname.'_lng = document.getElementById("ctrl_'.$this->strId.'_1");
							'.$mapname.'_zoom = document.getElementById("ctrl_'.$this->strId.'_2");
							
							'.$mapname.'_search = document.getElementById("'.$mapname .'_search");
							'.$mapname.'_searchaction = document.getElementById("'.$mapname .'_searchaction");

							google.maps.event.addListener('.$mapname.', "click", '.$mapname .'addMarker);

							google.maps.event.addListener('.$mapname.', "zoom_changed", function() {
								'.$mapname.'_zoom.set("value",'.$mapname.'.getZoom());
							});

							google.maps.event.addListener('.$mapname.', "center_changed", function() {
								'.$mapname.'_zoom.set("value",'.$mapname.'.getZoom());
							});

							'.$mapname.'_searchaction.addEventListener("click", function() {
							    '.$mapname.'codeAddress();
							}, false);

						';

						if (is_array($this->varValue)){
						
							if (is_numeric($this->varValue[0]) && is_numeric($this->varValue[1])){
									
								$map .='var lat = '.$this->varValue[0].';
										var lng = '.$this->varValue[1].';
										
										if (lat && lng  ){
											var marker = new google.maps.Marker({
												position: new google.maps.LatLng(lat,lng),
												map: '.$mapname.'
											}
										);
										'.$mapname.'markers.push(marker);
										'.$mapname.'.center = new google.maps.LatLng(lat,lng);
									}';
							}		
					
					if (is_numeric($this->varValue[2])){
						$map .= '
							'.$mapname.'.setZoom('.$this->varValue[2].');
						';
					}

			}
			
							
			$map .=	'

					    }

						function '.$mapname .'addMarker(event) {
						
							for (var i = 0; i < '.$mapname.'markers.length; i++) {
								'.$mapname.'markers[i].setMap(null);
						    }
						
							var marker = new google.maps.Marker({
								position: event.latLng,
								map: '.$mapname.'
							});
							'.$mapname.'markers.push(marker);
						
							'.$mapname.'_lat.set("value", event.latLng.lat());
							'.$mapname.'_lng.set("value", event.latLng.lng());
							'.$mapname.'_zoom.set("value",'.$mapname.'.getZoom());
						
							'.$mapname.'.setCenter(event.latLng);
						};	

					</script>';
 	
		$map .= '<input type="text" class="tl_text" id="'.$mapname .'_search" > <input type="button" class="tl_submit" value="Suche" id="'.$mapname .'_searchaction"><br><br>
				<div class="tl_text" id="'.$mapname .'_canvas" style="width:auto; height:300px;"></div><br>';

		echo $map;
		
		
		
		
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

		//array_push($arrFields, '<button name="code" id="xyz" class="tl_text_3" onclick="doCommand('bold');">Geocode</button>');
	

		return sprintf('<div id="ctrl_%s"%s>%s</div>%s',
						$this->strId,
						(($this->strClass != '') ? ' class="' . $this->strClass . '"' : ''),
						implode(' ', $arrFields),
						$this->wizard);


		
		

	}
}