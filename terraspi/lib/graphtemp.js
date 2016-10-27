$(function () {
    $.getJSON('data.php', function (data) {  // on récupère les data du json.

        $('#container').highcharts({          //on dessinera le graphe dans la div container
            chart: {
                zoomType: 'x'                 // le type de graphe
            },
            title: {
                text: 'temperature'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                        'Click et selectionne une zone pour zoomer' : 'Pinch the chart to zoom in'
            },
        tooltip: {                               
            shared: true
        }, 
        
        // le xAxis
            xAxis: {
                categories: data[0]['data']   //correspond au 1er groupe de donnée du json créer par data.php (dateandtime)
                },                           
                
                // Premier yAxis
            yAxis: [{ 

            title: {
                text: 'temperature',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },

            //min : 20,      // min et max , commenté ces 2 lignes pour un ajustement auto des y
            //max : 40,
            tooltip: {
                valueSuffix: ' °C'
            },          
            labels: {
                format: '{value} °C',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            }

        }, { // Second yAxis

            title: {
                text: 'temperature',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            //min : 20,
            //max : 40,
            tooltip: {
                valueSuffix: '°C',
            },
            opposite: true,
            labels: {
                format: '{value} °C',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }

        }],
                legend: {                            // la légende 
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -100,
                    y: 0,
                    floating: true,
                    borderWidth: 0
                },
            plotOptions: {                         // la fonction zoom 
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [{                              // les séries
                type: 'spline',
                name: 'température pointchaud',
                yAxis: 0,
                tooltip: {
                valueSuffix: ' °C'
            },              
                data: data[1].data     //correspond au 2 ème groupe de donnée du json créer par data.php (température pointchaud)
            }, {
                type: 'spline',
                name: 'température pointfroid',
                yAxis: 1,
                tooltip: {
                valueSuffix: ' °C'
            },
                data: data[3].data     //correspond au 4 ème groupe de donnée du json créer par data.php (température pointfroid)
            }]
        });
    });
});
        


