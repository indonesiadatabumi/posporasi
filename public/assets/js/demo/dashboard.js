
var handleVectorMap = function() {
	"use strict";
	if ($('#world-map').length !== 0) {
		var fillColor = ($('#world-map').attr('data-theme') == 'transparent') ? 'rgba('+ app.color.whiteRgb + ', .25)' : app.color.gray600;
		$('#world-map').vectorMap({
			map: 'world_mill',
			scaleColors: [app.color.gray300, app.color.gray600],
			normalizeFunction: 'polynomial',
			hoverOpacity: 0.5,
			hoverColor: false,
			zoomOnScroll: false,
			markerStyle: {
				initial: {
					fill: app.color.teal,
					stroke: 'transparent',
					r: 3
				}
			},
			regionStyle: {
				initial: {
					fill: fillColor,
					"fill-opacity": 1,
					stroke: 'none',
					"stroke-width": 0.4,
					"stroke-opacity": 1
				},
				hover: {
					"fill-opacity": 0.8
				},
				selected: {
					fill: 'yellow'
				},
				selectedHover: { }
			},
			focusOn: {
				x: 0.5,
				y: 0.5,
				scale: 0
			},
			backgroundColor: 'transparent',
			markers: [
				{latLng: [41.90, 12.45], name: 'Vatican City'},
				{latLng: [43.73, 7.41], name: 'Monaco'},
				{latLng: [-0.52, 166.93], name: 'Nauru'},
				{latLng: [-8.51, 179.21], name: 'Tuvalu'},
				{latLng: [43.93, 12.46], name: 'San Marino'},
				{latLng: [47.14, 9.52], name: 'Liechtenstein'},
				{latLng: [7.11, 171.06], name: 'Marshall Islands'},
				{latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'},
				{latLng: [3.2, 73.22], name: 'Maldives'},
				{latLng: [35.88, 14.5], name: 'Malta'},
				{latLng: [12.05, -61.75], name: 'Grenada'},
				{latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'},
				{latLng: [13.16, -59.55], name: 'Barbados'},
				{latLng: [17.11, -61.85], name: 'Antigua and Barbuda'},
				{latLng: [-4.61, 55.45], name: 'Seychelles'},
				{latLng: [7.35, 134.46], name: 'Palau'},
				{latLng: [42.5, 1.51], name: 'Andorra'},
				{latLng: [14.01, -60.98], name: 'Saint Lucia'},
				{latLng: [6.91, 158.18], name: 'Federated States of Micronesia'},
				{latLng: [1.3, 103.8], name: 'Singapore'},
				{latLng: [1.46, 173.03], name: 'Kiribati'},
				{latLng: [-21.13, -175.2], name: 'Tonga'},
				{latLng: [15.3, -61.38], name: 'Dominica'},
				{latLng: [-20.2, 57.5], name: 'Mauritius'},
				{latLng: [26.02, 50.55], name: 'Bahrain'},
				{latLng: [0.33, 6.73], name: 'S�o Tom� and Pr�ncipe'}
			]
		});
	}
};

var handleInteractiveChart = function () {
    "use strict";
    $('#interactive-chart').empty();
    
    function showTooltip(x, y, contents) {
        $('<div id="tooltip" class="flot-tooltip">' + contents + '</div>').css({
            top: y - 45,
            left: x - 55
        }).appendTo("body").fadeIn(200);
    }

    if ($('#interactive-chart').length !== 0) {
        
        // Data untuk Pengeluaran, Pemasukan, dan Keuntungan selama bulan Desember
        var pengeluaran = [
            [1, 40], [2, 35], [3, 45], [4, 50], [5, 60], [6, 55], [7, 65], [8, 70], [9, 80], [10, 75], 
            [11, 90], [12, 85], [13, 100], [14, 110], [15, 120], [16, 130], [17, 140], [18, 135], [19, 145], [20, 150], 
            [21, 160], [22, 155], [23, 165], [24, 170], [25, 175], [26, 180], [27, 185], [28, 190], [29, 195], [30, 200], [31, 210]
        ];
        var pemasukan = [
            [1, 50], [2, 45], [3, 55], [4, 65], [5, 75], [6, 70], [7, 85], [8, 90], [9, 95], [10, 85], 
            [11, 105], [12, 95], [13, 110], [14, 115], [15, 130], [16, 135], [17, 140], [18, 145], [19, 150], [20, 155], 
            [21, 160], [22, 165], [23, 170], [24, 180], [25, 190], [26, 200], [27, 205], [28, 210], [29, 215], [30, 220], [31, 230]
        ];
        var keuntungan = pemasukan.map(function(val, index) {
            return [val[0], val[1] - pengeluaran[index][1]];
        });

        var xLabel = [
            [1,'Dec 1'],[2,''],[3,'Dec 3'],[4,''],[5,'Dec 5'],[6,''],[7,'Dec 7'],[8,''],[9,'Dec 9'],[10,''], 
            [11,'Dec 11'],[12,''],[13,'Dec 13'],[14,''],[15,'Dec 15'],[16,''],[17,'Dec 17'],[18,''],[19,'Dec 19'],[20,''], 
            [21,'Dec 21'],[22,''],[23,'Dec 23'],[24,''],[25,'Dec 25'],[26,''],[27,'Dec 27'],[28,''],[29,'Dec 29'],[30,'Dec 30'],[31,'Dec 31']
        ];
        
        $.plot($("#interactive-chart"), [{
                data: pengeluaran, 
                label: "Pengeluaran", 
                color: app.color.red,
                lines: { show: true, fill: false, lineWidth: 2 },
                points: { show: true, radius: 3, fillColor: app.color.componentBg },
                shadowSize: 0
            }, {
                data: pemasukan,
                label: 'Pemasukan',
                color: app.color.green,
                lines: { show: true, fill: false, lineWidth: 2 },
                points: { show: true, radius: 3, fillColor: app.color.componentBg },
                shadowSize: 0
            }, {
                data: keuntungan,
                label: 'Keuntungan',
                color: app.color.blue,
                lines: { show: true, fill: false, lineWidth: 2 },
                points: { show: true, radius: 3, fillColor: app.color.componentBg },
                shadowSize: 0
            }], {
            xaxis: {  ticks: xLabel, tickDecimals: 0, tickColor: 'rgba('+ app.color.darkRgb + ', .2)' },
            yaxis: {  ticks: 10, tickColor: 'rgba('+ app.color.darkRgb + ', .2)', min: 0, max: 250 },
            grid: { 
                hoverable: true, 
                clickable: true,
                tickColor: 'rgba('+ app.color.darkRgb + ', .2)',
                borderWidth: 1,
                backgroundColor: 'transparent',
                borderColor: 'rgba('+ app.color.darkRgb + ', .2)'
            },
            legend: {
                labelBoxBorderColor: 'rgba('+ app.color.darkRgb + ', .2)',
                margin: 10,
                noColumns: 1,
                show: true
            }
        });

        var previousPoint = null;
        $("#interactive-chart").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint !== item.dataIndex) {
                    previousPoint = item.dataIndex;
                    $("#tooltip").remove();
                    var y = item.datapoint[1].toFixed(2);
                    var content = item.series.label + " " + y;
                    showTooltip(item.pageX, item.pageY, content);
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
            event.preventDefault();
        });
    }
};


var handleDonutChart = function () {
	"use strict";
	$('#donut-chart').empty();
	if ($('#donut-chart').length !== 0) {
		var donutData = [
			{ label: "Chrome",  data: 35, color: 'rgba('+ app.color.purpleRgb + ', .75)'},
			{ label: "Firefox",  data: 30, color: 'rgba('+ app.color.purpleRgb + ', 1)'},
			{ label: "Safari",  data: 15, color: 'rgba('+ app.color.purpleRgb + ', .5)'},
			{ label: "Opera",  data: 10, color: app.color.blue},
			{ label: "IE",  data: 5, color: 'rgba('+ app.color.blueRgb + ', .75)'}
		];
		$.plot('#donut-chart', donutData, {
			series: {
				pie: {
					innerRadius: 0.5,
					show: true,
					label: {
						show: true
					},
					stroke: {
						color: app.color.componentBg
					}
				}
			},
			legend: {
				show: true
			}
		});
	}
};

var handleDashboardSparkline = function() {
	"use strict";
	var options = {
		height: '50px',
		width: '100%',
		fillColor: 'transparent',
		lineWidth: 2,
		spotRadius: '4',
		highlightLineColor: app.color.blue,
		highlightSpotColor: app.color.blue,
		spotColor: false,
		minSpotColor: false,
		maxSpotColor: false
	};
	function renderDashboardSparkline() {
		$('#sparkline-unique-visitor').empty();
		$('#sparkline-bounce-rate').empty();
		$('#sparkline-total-page-views').empty();
		$('#sparkline-avg-time-on-site').empty();
		$('#sparkline-new-visits').empty();
		$('#sparkline-return-visitors').empty();
		
		var value = [50,30,45,40,50,20,35,40,50,70,90,40];
		options.type = 'line';
		options.height = '23px';
		options.lineColor = app.color.red;
		options.highlightLineColor = app.color.red;
		options.highlightSpotColor = app.color.red;

		var countWidth = $('#sparkline-unique-visitor').width();
		if (countWidth >= 200) {
			options.width = '200px';
		} else {
			options.width = '100%';
		}

		$('#sparkline-unique-visitor').sparkline(value, options);
		options.lineColor = app.color.orange;
		options.highlightLineColor = app.color.orange;
		options.highlightSpotColor = app.color.orange;
		$('#sparkline-bounce-rate').sparkline(value, options);
		options.lineColor = app.color.green;
		options.highlightLineColor = app.color.green;
		options.highlightSpotColor = app.color.green;
		$('#sparkline-total-page-views').sparkline(value, options);
		options.lineColor = app.color.blue;
		options.highlightLineColor = app.color.blue;
		options.highlightSpotColor = app.color.blue;
		$('#sparkline-avg-time-on-site').sparkline(value, options);
		options.lineColor = app.color.gray;
		options.highlightLineColor = app.color.gray;
		options.highlightSpotColor = app.color.gray;
		$('#sparkline-new-visits').sparkline(value, options);
		options.lineColor = app.color.black;
		options.highlightLineColor = app.color.black;
		options.highlightSpotColor = app.color.black;
		$('#sparkline-return-visitors').sparkline(value, options);
	}
    
	renderDashboardSparkline();

	$(window).on('resize', function() {
		renderDashboardSparkline();
	});
};

var handleDashboardDatepicker = function() {
	"use strict";
	$('#datepicker-inline').datepicker({
		todayHighlight: true
	});
};

var handleDashboardTodolist = function() {
	"use strict";
	$('[data-change=todolist]').click(function() {
		if ($(this).is(':checked')) {
			$(this).closest('.todolist-item').addClass('active');
		} else {
			$(this).closest('.todolist-item').removeClass('active');
		}
	});
};

var handleDashboardGritterNotification = function() {
	setTimeout(function() {
		$.gritter.add({
			title: 'Welcome back, Admin!',
			text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus lacus ut lectus rutrum placerat.',
			image: '../assets/img/user/user-2.jpg',
			sticky: true,
			time: '',
			class_name: 'my-sticky-class'
		});
	}, 1000);
};

var Dashboard = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleDashboardGritterNotification();
			handleDashboardSparkline();
			handleInteractiveChart();
			handleDonutChart();
			handleDashboardTodolist();
			handleVectorMap();
			handleDashboardDatepicker();
			
			$(document).on('theme-change', function() {
				handleInteractiveChart();
				handleDonutChart();
			});
		}
	};
}();

$(document).ready(function() {
	Dashboard.init();
});	