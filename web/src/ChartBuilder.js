function ChartBuilder () {

	this.title = "";
	this.chart;
		
	this.init = function(urlPath){

		if(this.hasParameters(urlPath)){
			this.find_chartTitle(urlPath);

			var parameters = this.getParameters(urlPath);
			this.getData(parameters);

			this.addEvent_resize();	
		} else {
			console.error('You have to provide parameters');
			console.error('\t tableName');
			console.error('\t sensor_idColumn');
			console.error('\t ...');
		}
	}

	this.hasParameters = function(urlPath){
		return !(urlPath.indexOf('?') == -1);
	}

	this.find_chartTitle = function(urlPath){
		var re = /&chartTitle=([a-z]*)/i;
		var title = urlPath.match(re);

		if(title != null)
			this.title = title[1];
		else
			this.title = "";
		
	}

	this.getParameters = function(urlPath){
		return urlPath.substr(urlPath.indexOf('?') + 1);
	}

	this.formatData = function(data){
		var series = [];
		$.each(data, function(key, value) {
		    var temp = {};
		    temp.data = [];
		    temp.name = key;
		    $.each(value, function(k, v) {
		        temp.data.push([parseFloat(v.timestamp), parseFloat(v.value)]);
		    });
		    
		    series.push(temp);
		});
		return series;
	}

	this.constructChart = function(data){
		var options = { 
	    	title : {
	    		text : this.title
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
		    series: this.formatData(data)
		};

		this.chart = new Highcharts.Chart(options);
	}

	this.getData = function(parameters){
		console.info("Starting AJAX request");
		var self = this;
		$.ajax({
			url: 'dbCharts.php',
			type: 'get',
			dataType: 'json',
			data: parameters,
			async: false
		})
		.done(function(data) {
			console.info("AJAX request done");
			self.constructChart(data);
		});
	}

	this.addEvent_resize = function (){
		var self = this;
		$(window).resize(function(event) {	
			self.chart.setSize(
				$(window).width(), 
				$(window).height(),
				false
			);
		});
	};
}