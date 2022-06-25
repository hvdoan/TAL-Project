// import * as am5 from "/API/amCharts/index.js";
// import * as am5xy from "/API/amCharts/xy.js";

// window.onload = loadStatistics;

function loadUserByCreation(users, totalUsers){
	
	am5.ready(function (){
		
		// Create root and chart
		let root = am5.Root.new("userCreationChartDiv");
		
		root.setThemes([
			am5themes_Animated.new(root)
		]);
		
		let chart = root.container.children.push(
			am5xy.XYChart.new(root, {
				panY: false,
				layout: root.verticalLayout,
				maxTooltipDistance: 0
			})
		);
		
		let data = [];
		for(let i = 0; i < users.length; i++){
			let creationDate = new Date(users[i].creationDate);
			// am5.time.add(creationDate, "day", 1);
			
			data.push({
				date: creationDate.getTime(),
				// value: users[i].id * 10
				value: i,
			})
		}

		for(let i = 0; i < totalUsers.length; i++){
			//let creationDate = new Date(totalUsers[i].time);
			// am5.time.add(creationDate, "day", 1);

			data.push({
				date: totalUsers[i].time * 1000,
				// value: users[i].id * 10
				value2: i
			})
		}
		console.log(data);
		
		// Create Y-axis
		let yAxis = chart.yAxes.push(
			am5xy.ValueAxis.new(root, {
				extraTooltipPrecision: 1,
				renderer: am5xy.AxisRendererY.new(root, {})
			})
		);
		
		// Create X-Axis
		let xAxis = chart.xAxes.push(
			am5xy.DateAxis.new(root, {
				baseInterval: {timeUnit: "day", count: 1},
				renderer: am5xy.AxisRendererX.new(root, {})
			})
		);
		
		xAxis.get("dateFormats")["day"] = "dd/MM";
		xAxis.get("periodChangeDateFormats")["day"] = "MMMM";
		
		// Create series
		function createSeries(name, field){
			let series = chart.series.push(
				am5xy.LineSeries.new(root, {
					name: name,
					xAxis: xAxis,
					yAxis: yAxis,
					valueYField: field,
					valueXField: "date",
					tooltip: am5.Tooltip.new(root, {})
				})
			);
			
			series.bullets.push(function (){
				return am5.Bullet.new(root, {
					sprite: am5.Circle.new(root, {
						radius: 5,
						fill: series.get("fill")
					})
				});
			});

			series.fills.template.setAll({
				fillOpacity: 0.5,
				visible: true
			});
			
			series.strokes.template.set("strokeWidth", 2);
			
			series.get("tooltip").label.set("text", "[bold]{name}[/]\n{valueX.formatDate()}: {valueY}")
			series.data.setAll(data);
		}
		
		createSeries("Utilisateurs inscrits", "value");
		createSeries("Visiteurs", "value2");
		// Add cursor
		chart.set("cursor", am5xy.XYCursor.new(root, {
			behavior: "zoomXY",
			xAxis: xAxis
		}));
		
		xAxis.set("tooltip", am5.Tooltip.new(root, {
			themeTags: ["axis"]
		}));
		
		yAxis.set("tooltip", am5.Tooltip.new(root, {
			themeTags: ["axis"]
		}));

		// Add legend
		var legend = chart.children.push(am5.Legend.new(root, {}));
		legend.data.setAll(chart.series.values);
	
	}); // end am5.ready()
}

function loadStatistics(){
	
	am5.ready(function (){
		
		// Create root element
		// https://www.amcharts.com/docs/v5/getting-started/#Root_element
		let root = am5.Root.new("userCreationChartDiv");
		
		
		// Set themes
		// https://www.amcharts.com/docs/v5/concepts/themes/
		root.setThemes([
			am5themes_Animated.new(root)
		]);
		
		
		// Create chart
		// https://www.amcharts.com/docs/v5/charts/xy-chart/
		let chart = root.container.children.push(am5xy.XYChart.new(root, {
			panX: true,
			panY: true,
			wheelX: "panX",
			wheelY: "zoomX",
			pinchZoomX: true
		}));
		
		// Add cursor
		// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
		let cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
			behavior: "none"
		}));
		cursor.lineY.set("visible", false);
		
		
		// Generate random data
		let date = new Date();
		date.setHours(0, 0, 0, 0);
		let value = 100;
		
		function generateData(){
			value = Math.round((Math.random() * 10 - 5) + value);
			am5.time.add(date, "day", 1);
			return {
				date: date.getTime(),
				value: value
			};
		}
		
		function generateDatas(count){
			let data = [];
			for(let i = 0; i < count; ++i){
				data.push(generateData());
			}
			return data;
		}
		
		
		// Create axes
		// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
		let xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
			maxDeviation: 0.5,
			baseInterval: {
				timeUnit: "day",
				count: 1
			},
			renderer: am5xy.AxisRendererX.new(root, {
				pan: "zoom"
			}),
			tooltip: am5.Tooltip.new(root, {})
		}));
		
		let yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
			maxDeviation: 1,
			renderer: am5xy.AxisRendererY.new(root, {
				pan: "zoom"
			})
		}));
		
		
		// Add series
		// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
		let series = chart.series.push(am5xy.SmoothedXLineSeries.new(root, {
			name: "Series",
			xAxis: xAxis,
			yAxis: yAxis,
			valueYField: "value",
			valueXField: "date",
			tooltip: am5.Tooltip.new(root, {
				labelText: "{valueY}"
			})
		}));
		
		series.fills.template.setAll({
			visible: true,
			fillOpacity: 0.2
		});
		
		series.bullets.push(function (){
			return am5.Bullet.new(root, {
				locationY: 0,
				sprite: am5.Circle.new(root, {
					radius: 4,
					stroke: root.interfaceColors.get("background"),
					strokeWidth: 2,
					fill: series.get("fill")
				})
			});
		});
		
		
		// Add scrollbar
		// https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
		chart.set("scrollbarX", am5.Scrollbar.new(root, {
			orientation: "horizontal"
		}));
		
		
		let data = generateDatas(50);
		series.data.setAll(data);
		
		
		// Make stuff animate on load
		// https://www.amcharts.com/docs/v5/concepts/animations/
		series.appear(1000);
		chart.appear(1000, 100);
		
	}); // end am5.ready()
	
}