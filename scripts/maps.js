$(document).ready(function(){
	$('#mapico').click(function()
	{
		$('#mapico').addClass('hide');
		$('.m_contacts.wpadding').removeClass('wpadding');
		$('.map.hide').removeClass('hide');
		yMaps($('#addr input').attr('value'));
	});

});

function yMaps(geocoder) {
var map, geoResult;
	YMaps.jQuery(function () {
		$('#YMapsID').html('');
		map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
		var count = $('#addr input').length;
		var s = new YMaps.Style();
			s.iconStyle = new YMaps.IconStyle();
			s.iconStyle.href = '/im/mappointer.png';
			s.iconStyle.size = new YMaps.Point(27, 33);
			s.iconStyle.offset = new YMaps.Point(-11, -33);
		
		if (geocoder == '')
		{
			addr = $('#addr input').attr('value');
			geocoder = new YMaps.Geocoder(addr);
			YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
				map.setBounds(geocoder.get(0).getBounds());
				placemark = new YMaps.Placemark(geocoder.get(0).getGeoPoint(), {style: s});
				placemark.name=addr;
				map.addOverlay(placemark);
			});
		} else {
			addr = geocoder;
			geocoder = new YMaps.Geocoder(geocoder, {results: 1, boundedBy: map.getBounds()});
			YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
				if (this.length()) {
					geoResult = this.get(0);
					map.setBounds(geoResult.getBounds());
					placemark = new YMaps.Placemark(geocoder.get(0).getGeoPoint(), {style: s});
					map.removeAllOverlays();
					placemark.name=addr;
					map.addOverlay(placemark);
				}
			});
			YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, error) {
				alert("Произошла ошибка: " + error);
			})
		}
		
		var zoom = new YMaps.Zoom({customTips: [{index:17,value:"Дом"},{index:14,value:"Улица"},{index:11,value:"Город"}]});
		map.addControl(new YMaps.TypeControl());
		map.addControl(zoom, new YMaps.ControlPosition(YMaps.ControlPosition.BOTTOM_LEFT, new YMaps.Size (10, 35)));
	});

	function Address (value) {
		yMaps(value);
	}
}	
