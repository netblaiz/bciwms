// 'use strict';

// $(document).ready(function() {

function trackvisitors() {
    $.ajax({
        url: "core/tracks/track_insights.php",
        method: "GET",
        // data:  {month_id:$("#month_id").val(), year_id:$("#year_id").val()},
        success: function(data) {
            // var jsondata = JSON.stringify(data);
            // alert(jsondata);

            widgetChart();

            function widgetChart() {
                var chart = AmCharts.makeChart("visitor-list-graph", {
                    "type": "serial",
                    "hideCredits": true,
                    "theme": "light",
                    "dataDateFormat": "YYYY-MM-DD",
                    "precision": 0,
                    "valueAxes": [{
                        "id": "v1",
                        "title": "Visitors",
                        "position": "left",
                        "autoGridCount": false,
                        "labelFunction": function(value) {
                            return value;
                        }
                    }, {
                        "id": "v2",
                        "title": "New Visitors",
                        "gridAlpha": 0,
                        "position": "right",
                        "autoGridCount": false
                    }],
                    "graphs": [{
                            "id": "g4",
                            "valueAxis": "v1",
                            "lineColor": "#4680ff",
                            "fillColors": "#4680ff",
                            "fillAlphas": 1,
                            "type": "column",
                            "title": "Total visitors",
                            "valueField": "totalVisitors",
                            "clustered": false,
                            "columnWidth": 0.3,
                            "legendValueText": "[[value]]",
                            "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
                        }
                    ],
                    "chartCursor": {
                        "pan": true,
                        "valueLineEnabled": true,
                        "valueLineBalloonEnabled": true,
                        "cursorAlpha": 0,
                        "valueLineAlpha": 0.2
                    },
                    "categoryField": "monthVariable",
                    "categoryAxis": {
                        "parseDates": false,
                        "dashLength": 1,
                        "minorGridEnabled": true
                    },
                    "legend": {
                        "useGraphSettings": true,
                        "position": "top"
                    },
                    "balloon": {
                        "borderThickness": 1,
                        "cornerRadius": 5,
                        "shadowAlpha": 0
                    },
                    "dataProvider": data
                });

            };

        },
        error: function(data) {
            alert('Error Plotting Graph');
            // console.log(data);
        }
    });
}
// });
