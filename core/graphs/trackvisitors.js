
// rgba(44, 45, 73, 0.5),
// rgba(255, 246, 136, 0.5),

    $.ajax({
        url: "core/graphs/trackvisitors.php",
        method: "GET",
        success: function(data) {
            // var jsondata = JSON.stringify(data);
            // alert(jsondata);

            var monthVariable = [];
            var totalVisitors = [];

            for(var i in data) {
                monthVariable.push(data[i].monthVariable);
                totalVisitors.push(parseInt(data[i].totalVisitors));
            }

            // Define a plugin to provide data labels
            Chart.plugins.register({
                beforeDraw: function(chartInstance) {
                    var ctx = chartInstance.chart.ctx;
                    ctx.fillStyle = "white";
                    ctx.fillRect(0, 0, chartInstance.chart.width, chartInstance.chart.height);
                },
                afterDatasetsDraw: function(chart, easing) {
                    // To only draw at the end of animation, check for easing === 1
                    var ctx = chart.ctx;

                    chart.data.datasets.forEach(function (dataset, i) {
                        var meta = chart.getDatasetMeta(i);
                        if (!meta.hidden) {
                            meta.data.forEach(function(element, index) {
                                // Draw the text in black, with the specified font
                                ctx.fillStyle = 'rgb(255, 255, 255)';

                                var fontSize = 12;
                                var fontStyle = 'normal';
                                var fontFamily = 'Arial';
                                ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                                // Just naively convert to string for now
                                var dataString = dataset.data[index].toString();

                                // Make sure alignment settings are correct
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';

                                var padding = -20;
                                var position = element.tooltipPosition();
                                ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                            });
                        }
                    });
                }
            });


            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: monthVariable,
                    datasets: [{
                        label: 'Visitors',
                        data: totalVisitors,
                        backgroundColor: 'rgba(36, 40, 56, 0.9)',
                        borderColor: 'rgba(36, 40, 56, 0.9)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    title: {
                        display: true,
                        text: 'Website Traffic'
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: false
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                // max: 100,
                                min: 0,
                                // stepSize: 10
                            }
                        }]
                    },
                    legend: {
                        labels: {
                            fontColor: 'black'
                        },
                        // display: false
                    }
                }
            });

        },
        error: function(data) {
            alert('Error Plotting Graph');
            // console.log(data);
        }
    });
