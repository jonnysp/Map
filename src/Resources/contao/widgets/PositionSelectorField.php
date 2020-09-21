<?php

class PositionSelectorField extends Widget
{


	protected $strTemplate = 'be_widget';
	protected $blnSubmitInput = true;	
 

	public function generate()
	{
		
		$GLOBALS['TL_JAVASCRIPT'][] = '//www.openlayers.org/api/OpenLayers.js';

		$olmapname = 'olmap'.$this->__get('currentRecord');



		echo  '<div class="tl_text" id="'.$olmapname .'_canvas" style="width:auto; height:300px;"></div>

				<script type="text/javascript">
					
					var '.$olmapname.';
    				var '.$olmapname.'markers;
					var '.$olmapname.'marker;
					var '.$olmapname.'markerpos;
					var '.$olmapname.'markerzoom = '.(isset($this->varValue[2]) ? $this->varValue[2] : 5).';

    				function getLATLON(lat,lon){
    					return new OpenLayers.LonLat(lon, lat).transform('.$olmapname.'.getProjectionObject() , new OpenLayers.Projection("EPSG:4326"))
    				}

    				function toLATLON(lat,lon){
    					return new OpenLayers.LonLat( lon,lat).transform(new OpenLayers.Projection("EPSG:4326"),'.$olmapname.'.getProjectionObject())
    				}


	     			OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {                
	                	defaultHandlerOptions: {
	                	    "single": true,
	                	    "double": false,
	                	    "pixelTolerance": 0,
	                	    "stopSingle": false,
	                	    "stopDouble": false
	                	},
		
	                	initialize: function(options) {
	                	    this.handlerOptions = OpenLayers.Util.extend(
	                	        {}, this.defaultHandlerOptions
	                	    );
	                	    OpenLayers.Control.prototype.initialize.apply(
	                	        this, arguments
	                	    ); 
	                	    this.handler = new OpenLayers.Handler.Click(
	                	        this, {
	                	            "click": this.trigger
	                	        }, this.handlerOptions
	                	    );
	                	}, 
		
	                	trigger: function(e) {
	                	    '.$olmapname.'markerpos = '.$olmapname.'.getLonLatFromPixel(e.xy);
							'.$olmapname.'marker.moveTo('.$olmapname.'.getPixelFromLonLat('.$olmapname.'markerpos));
							'.$olmapname.'.setCenter('.$olmapname.'markerpos, '.$olmapname.'markerzoom);

							var pos = getLATLON('.$olmapname.'markerpos.lat,'.$olmapname.'markerpos.lon)
							document.getElementById("ctrl_'.$this->strId.'_0").set("value",pos.lat);
							document.getElementById("ctrl_'.$this->strId.'_1").set("value",pos.lon);
							document.getElementById("ctrl_'.$this->strId.'_2").set("value",'.$olmapname.'markerzoom);
	                	}

	            	});


					window.addEvent("domready", function() {
						'.$olmapname.'initialize();
					});

					function '.$olmapname.'initialize() {
						'.$olmapname.' = new OpenLayers.Map("'.$olmapname.'_canvas");
					    '.$olmapname.'.addLayer(new OpenLayers.Layer.OSM());

						'.$olmapname.'markers = new OpenLayers.Layer.Markers("Markers");
					    '.$olmapname.'.addLayer('.$olmapname.'markers);

					    '.$olmapname.'.setCenter(toLATLON( '.(isset($this->varValue[0]) ? $this->varValue[0] : 0).' ,'.(isset($this->varValue[1]) ? $this->varValue[1] : 0).'), '.(isset($this->varValue[2]) ? $this->varValue[2] : 3).');

					    var click = new OpenLayers.Control.Click();
              			'.$olmapname.'.addControl(click);
              			click.activate();

              			'.$olmapname.'marker = new OpenLayers.Marker(toLATLON( '.(isset($this->varValue[0]) ? $this->varValue[0] : 0).' ,'.(isset($this->varValue[1]) ? $this->varValue[1] : 0).'));
 						'.$olmapname.'markers.addMarker('.$olmapname.'marker);

						'.$olmapname.'.events.register("zoomend", '.$olmapname.', function() {
						    '.$olmapname.'markerzoom = '.$olmapname.'.zoom;
						    document.getElementById("ctrl_'.$this->strId.'_2").set("value",'.$olmapname.'markerzoom);
						});

					}


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