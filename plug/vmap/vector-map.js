$(function() {
	'use strict';
	$('#vmap').vectorMap({
		map: 'world_en',
		backgroundColor: '#E9ECEF',
		color: '#ffffff',
		hoverOpacity: 0.7,
		selectedColor: '#666666',
		enableZoom: true,
		showTooltip: true,
		scaleColors: ['#285cf7', '#007bff'],
		values: sample_data,
		normalizeFunction: 'polynomial',
		onLabelShow: function(event, label, code) {		

			for(var i = 0; i < map_tooltip_data_view.length; i++) {
				if(map_tooltip_data_view[i]["country_code"] == code) {
					break;
				}
			}
			label.html("<label>" + map_tooltip_data_view[i]["country_name"] + "</label>" + 
						"<br>" + "<label>cases :</label>" + "<label>" + map_tooltip_data_view[i]["total_cases"] + "</label>" + 
						"<br>" + "<label>serious :</label>" + "<label>" + map_tooltip_data_view[i]["serious_critical"] + "</label>" + 
						"<br>" + "<label>deaths :</label>" + "<label>" + map_tooltip_data_view[i]["total_deaths"] + "</label>" + 
						"<br>" + "<label>recovered :</label>" + "<label>" + map_tooltip_data_view[i]["total_recovered"] + "</label>");
		}

	});
	$('#vmap2').vectorMap({
		map: 'usa_en',
		showTooltip: true,
		backgroundColor: '#285cf7',
		hoverColor: '#00cccc'
	});
	$('#vmap3').vectorMap({
		map: 'canada_en',
		color: '#212229',
		borderColor: '#fff',
		backgroundColor: '#E9ECEF',
		hoverColor: '#007bff',
		showLabels: true
	});
	$('#vmap7').vectorMap({
		map: 'germany_en',
		color: '#285cf7',
		borderColor: '#fff',
		backgroundColor: '#efeff5',
		hoverColor: '#285cf7',
		showLabels: true
	});
	
	$('#vmap8').vectorMap({
		map: 'russia_en',
		color: '#3db4ec',
		borderColor: '#fff',
		backgroundColor: '#efeff5',
		hoverColor: '#3db4ec',
		showLabels: true
	});
	
	$('#vmap9').vectorMap({
		map: 'france_fr',
		color: '#f10075',
		borderColor: '#fff',
		backgroundColor: '#efeff5',
		hoverColor: '#f10075',
		showLabels: true
	});
});