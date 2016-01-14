
//console.log(window.location.href);
$('#warning').hide();
var dataSend = window.location.href;

if(dataSend.indexOf('?') == -1){
	$('#warning').show();
} else {

	var re = /&chartTitle=([a-z]*)/i;
	var title = dataSend.match(re);

	if(title != null){
		title = title[1];
		console.log(title);
	} else {
		title = "";
	}

	dataSend = dataSend.substr(dataSend.indexOf('?') + 1);

	var chart;

	console.log("Starting AJAX request");

	$.ajax({
		url: 'dbCharts.php',
		type: 'get',
		dataType: 'json',
		data: dataSend,
		async: false
	})
	.done(function(data) {
		console.log("AJAX request done");
		//console.log(data);

		var options = { 
	    	title : {
	    		text : title
	    	},
		    chart: { 
		    	renderTo: 'graph',
		    	zoomType : 'x' ,
		    	height: window.innerHeight,
		    	width : window.innerWidth
		    },
		    plotOptions: {
		        line: {
		            marker: {
		                enabled: false
		            }
		        }
		    },
		    xAxis: { type: 'datetime' },
		    series: []
		};

		$.each(data, function(key, value) {
			console.log(data);
		    var temp = {};
		    temp.data = [];
		    temp.name = key;
		    $.each(value, function(k, v) {
		        temp.data.push([parseFloat(v.timestamp), parseFloat(v.value)]);
		    });
		    
		    options.series.push(temp);
		});

		//console.log(options.series);

		chart = new Highcharts.Chart(options);
	});

	$(window).resize(function(event) {	
		chart.setSize(
			$(window).width(), 
			$(window).height(),
			false
		);
	});
}