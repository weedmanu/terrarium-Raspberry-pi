
<script>
  
    RGraph.CSV('../csv/result.csv', function (csv)        //on récupère le fichier data.csv
    {

        var row = csv.getRow(1, 0);    // on enregistre les ligne du csv dans des variables
        var row1 = csv.getRow(1, 1);
        var row2 = csv.getRow(2, 0);
        var row3 = csv.getRow(2, 1);

        var gauge = new RGraph.Gauge({
            id: 'cvs',           // l id du canvas
            min: 0,
            max: 100,
            value: row[0],       // nos variable
            options: {
            titleTop: 'point froid',
            titleBottom: '%',
            colorsRanges: [[0, 25, '#DC3912'], [25, 35,'#FF9900'], [35, 60, '#00FF00'], [60, 70, '#FF9900'], [70,100,'#DC3912']] ,
            }                        // ci dessus on personnalise les zones rouge verte orange .
        }).draw();
    


        var gauge1 = new RGraph.Gauge({
            id: 'cvs1',
            min: 0,
            max: 60,
            value: row1[0],        // nos variable
            options: {
            titleTop: 'point froid',
            titleBottom: '°C',
            colorsRanges: [[0, 10, '#DC3912'], [10, 15,'#FF9900'], [15, 27, '#00FF00'], [27, 32, '#FF9900'], [32,60,'#DC3912']] ,
            }                     // ci dessus on personnalise les zones rouge verte orange .
        }).draw();
        


        var gauge2 = new RGraph.Gauge({
            id: 'cvs2',        
            min: 0,
            max: 100,
            value: row2[0],     // nos variable
            options: {
            titleTop: 'point chaud',
            titleBottom: '%',
            colorsRanges: [[0, 15, '#DC3912'], [15, 25,'#FF9900'], [25, 45, '#00FF00'], [45, 55, '#FF9900'], [55,100,'#DC3912']] ,
            }                     // ci dessus on personnalise les zones rouge verte orange .
        }).draw();
    


        var gauge3 = new RGraph.Gauge({
            id: 'cvs3',
            min: 0,
            max: 60,
            value: row3[0],     // nos variable
            options: {
            titleTop: 'point chaud',
            titleBottom: '°C',
            colorsRanges: [[0, 15, '#DC3912'], [15, 20,'#FF9900'], [20, 35, '#00FF00'], [35, 40, '#FF9900'], [40,60,'#DC3912']] ,
            }                 // ci dessus on personnalise les zones rouge verte orange .
        }).draw();
    });

</script>

<div id="titre">
    <div class="element">Température</div> 
    <div class="element">Humiditée</div>    
</div>  

         
<div id="canvas">

 <canvas class="element" id="cvs1" width="250" height="250" >       <!--  les jauges -->
    [No canvas support]
</canvas>

 <canvas class="element" id="cvs3" width="250" height="250" >
    [No canvas support]
</canvas>

 <canvas class="element" id="cvs" width="250" height="250" >
    [No canvas support]
</canvas>

 <canvas class="element" id="cvs2" width="250" height="250" >
    [No canvas support]
</canvas>
</div>




