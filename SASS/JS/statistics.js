//userCreationChartDiv
function loadUserByCreation(users){
	
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

		chart.children.unshift(am5.Label.new(root, {
			text: "Evolution du nombre d'utilisateurs inscrits",
			fontSize: 25,
			fontWeight: "400",
			textAlign: "center",
			x: am5.percent(50),
			centerX: am5.percent(50),
			paddingTop: 0,
			paddingBottom: 20
		}));
		
		let data = [];
		for(let i = 0; i < users.length; i++){
			let creationDate = new Date(users[i].creationDate);
			
			data.push({
				date: creationDate.getTime(),
				value: i
			})
		}
		
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
			
			series.strokes.template.set("strokeWidth", 2);
			
			series.get("tooltip").label.set("text", "[bold]{name}[/]\n{valueX.formatDate()}: {valueY}")
			series.data.setAll(data);
		}
		
		createSeries("Series", "value");
		
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
		let legend = chart.children.push(am5.Legend.new(root, {}));
		legend.data.setAll(chart.series.values);
	
	}); // end am5.ready()
}

//avisChartDiv
function loadAvis(ratings, averageRatings){
	am5.ready(function (){
		
		// Create root element
		// https://www.amcharts.com/docs/v5/getting-started/#Root_element
		let avisChart = am5.Root.new("avisChartdiv");
		
		// Set themes
		// https://www.amcharts.com/docs/v5/concepts/themes/
		avisChart.setThemes([
			am5themes_Animated.new(avisChart)
		]);
		
		// Create chart
		// https://www.amcharts.com/docs/v5/charts/xy-chart/
		let chart = avisChart.container.children.push(am5xy.XYChart.new(avisChart, {
			panX: true,
			panY: true,
			wheelX: "none",
			wheelY: "none"
		}));
		
		chart.children.unshift(am5.Label.new(avisChart, {
			text: "Moyenne des avis : " + averageRatings[0].average,
			fontSize: 25,
			fontWeight: "400",
			textAlign: "center",
			x: am5.percent(50),
			centerX: am5.percent(50),
			paddingTop: 0,
			paddingBottom: 20
		}));
		
		var cursor = chart.set("cursor", am5xy.XYCursor.new(avisChart, {}));
		cursor.lineY.set("visible", false);
		
		// We don't want zoom-out button to appear while animating, so we hide it
		chart.zoomOutButton.set("forceHidden", true);
		
		// Create axes
		// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
		let xRenderer = am5xy.AxisRendererX.new(avisChart, {
			maxGridDistance: 20,
		});
		xRenderer.labels.template.setAll({
			centerY: am5.p50,
			centerX: am5.p50,
			paddingRight: 15
		});
		// xRenderer.grid.template.set("visible", false);
		
		let xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(avisChart, {
			maxDeviation: 0.3,
			categoryField: "rate",
			renderer: xRenderer,
			tooltip: am5.Tooltip.new(avisChart, {})
		}));
		
		let yAxis = chart.yAxes.push(am5xy.ValueAxis.new(avisChart, {
			maxDeviation: 0.3,
			categoryField: "value",
			min: 0,
			renderer: am5xy.AxisRendererY.new(avisChart, {})
		}));
		
		// Add series
		// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
		let series = chart.series.push(am5xy.ColumnSeries.new(avisChart, {
			name: "Series 1",
			xAxis: xAxis,
			yAxis: yAxis,
			valueYField: "value",
			sequencedInterpolation: true,
			categoryXField: "rate",
			tooltip: am5.Tooltip.new(avisChart, {
				labelText:"{valueY} avis"
			})
		}));
		
		// Rounded corners for columns
		series.columns.template.setAll({
			cornerRadiusTL: 5,
			cornerRadiusTR: 5
		});
		
		// Make each column to be of a different color
		series.columns.template.adapters.add("fill", function (fill, target){
			return chart.get("colors").getIndex(series.columns.indexOf(target));
		});
		
		series.columns.template.adapters.add("stroke", function (stroke, target){
			return chart.get("colors").getIndex(series.columns.indexOf(target));
		});
		
		// Add Label bullet
		series.bullets.push(function (){
			return am5.Bullet.new(avisChart, {
				locationY: 1,
				sprite: am5.Label.new(avisChart, {
					text: "{valueYWorking.formatNumber('#.')}",
					fill: avisChart.interfaceColors.get("alternativeText"),
					centerY: 0,
					centerX: am5.p50,
					populateText: true
				})
			});
		});
		
		// Set data
		let data = [{
			"rate": "1 étoile",
			"value": parseInt(ratings[0][0].rating)
		}, {
			"rate": "2 étoiles",
			"value": parseInt(ratings[1][0].rating)
		}, {
			"rate": "3 étoiles",
			"value": parseInt(ratings[2][0].rating)
		}, {
			"rate": "4 étoiles",
			"value": parseInt(ratings[3][0].rating)
		}, {
			"rate": "5 étoiles",
			"value": parseInt(ratings[4][0].rating)
		}];
		
		xAxis.data.setAll(data);
		series.data.setAll(data);
		
		// Make stuff animate on load
		// https://www.amcharts.com/docs/v5/concepts/animations/
		series.appear(1000);
		chart.appear(1000, 100);
		
	}); // end am5.ready()
}