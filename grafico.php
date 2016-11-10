<!DOCTYPE html>
<html lang="es">
<head>
    <script lenguage=JacaScript>
        function recargar()
        {
            location.href=location.href
        }
        setInterval('recargar()',5000)
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Graficos</title>
    
    <meta name ="author" content ="Norfi Carrodeguas">
    
</head>
<body >  	
    <table>
    <td VALIGN=TOP>
    <?php 
            //$conexion=mysql_connect( "localhost","root","");
            //mysql_select_db("alumnos",$conexion) or die("no se pudo conectar");
            $tem=array();
            $hum=array();
            $pre=array();
            $cont=1;
            $conh=0;
            $conp=0;
            $c2=1;
            $fp = fopen("c:\\views\\info.txt", "r"); 
            while(!feof($fp)) {
                 $linea = fgets($fp);
                 //$sql="INSERT  into satelite  values ($linea);";
                 //if (!mysql_query($sql,$conexion)) {
	               // echo mysql_errno($conexion) . ": " . mysql_error($conexion) . "\n";
                 //}	    
                 if ((strcmp(substr($linea,0,3), "155") == 0)){
                    // matriz de temperaturas
                    $pos=0;
                    $conta=0;
                    $largo=strlen ($linea);
                    $pos = strpos($linea, ",");
                    $conta=$pos+1;
                    //encuentra la segunda coma
                    while (($conta<=$largo) and ((strcmp($linea[$conta], ",") !== 0)))
                    {
                        $conta=$conta+1;
                    }
                    if (strcmp(substr($linea,$pos,1),"0")!==0){
                       $tem[$cont]=substr($linea,$pos,$conta-$pos-1);
                       $cont=$cont+1;    
                    }
                     // matriz de humedad
                    $pos=$conta+1; // la posicon encontrada antes
                    $conta=$conta+1;
                    while (($conta<=$largo) and ((strcmp($linea[$conta], ",") !== 0)))
                    {
                        $conta=$conta+1;
                    }
                    if (strcmp(substr($linea,$pos,1),"0")!==0){
                       $hum[$conh]=substr($linea,$pos,$conta-$pos-1);
                       $conh=$conh+1;    
                    }
                     // matriz de presión
                    $pos=$conta+1; // la posicon encontrada antes
                    $conta=$conta+1;
                    while (($conta<=$largo) and ((strcmp($linea[$conta], ",") !== 0)))
                    {
                        $conta=$conta+1;
                    }
                    if (strcmp(substr($linea,$pos,1),"0")!==0){
                       $pre[$conp]=substr($linea,$pos,$conta-$pos-1);
                       $conp=$conp+1;    
                    }
                 }
            }
            fclose($fp);
            $sumar=1;
            if ($cont<=100) {
               $sumar=1;
            } else 
            {
                if ($cont<=1000) {
                   $sumar=floor($cont/100)*5;
                 } else 
                 {
                    if ($cont<=10000) {
                       $sumar=floor($cont/1000)*50;
                    } else
                    {
                       if ($cont<=100000) {
                         $sumar=floor($cont/10000)*500;
                       }
                    } 
                }
            }
            //echo $cont.", ";
        ?>        
        <?php 
           // etiquetas y matriz para temperatura 
           $c2=1;
           $eti="'1785'";
           $var="26,";
           $utem=0;
           while($c2<=$cont-1){
             $var=$var.",".$tem[$c2];
             $utem=$tem[$c2];
            //-------------------------   
               $seaLevel=1013.25;
               $altitud = ((pow(($seaLevel/$pre[$c2]),0.190223)-1.0)*($tem[$c2]+273.15))/0.0065;
               $altitud=round($altitud,0);
            //-------------------------
               
               
             //$eti=$eti.",'".$c2."'";
            $eti=$eti.",'".$altitud."'";
             $c2=$c2+$sumar;
           }
           $eti=$eti.",'".$altitud."'";
           //$eti=$eti.",'".$c2."'";
           //echo $sumar;
        ?>
        <?php 
           // etiquetas y matriz para humedad 
           $c2=1;
           $eth="'1785'";
           $vah="26,";
           while($c2<=$conh-1){
             $vah=$vah.",".$hum[$c2];
               
             //-------------------------   
               $seaLevel=1013.25;
               $altitud = ((pow(($seaLevel/$pre[$c2]),0.190223)-1.0)*($tem[$c2]+273.15))/0.0065;
               $altitud=round($altitud,0);
             //-------------------------
             //$eti=$eti.",'".$c2."'";
             $eth=$eth.",'".$altitud."'";
             $c2=$c2+$sumar;
           }
           //$var=$var.",30";
           $eth=$eth.",'".$altitud."'";
           //echo $sumar;
        ?>
        <h2><font color="red"><b>
        <?php 
           // etiquetas y matriz para presion 
           $c2=1;
           $etp="'1785'";
           $vap="816,";
           $upres=0;
           while($c2<=$conh-1){
             $vap=$vap.",".$pre[$c2];
            //-------------------------   
               $seaLevel=1013.25;
               $altitud = ((pow(($seaLevel/$pre[$c2]),0.190223)-1.0)*($tem[$c2]+273.15))/0.0065;
               $altitud=round($altitud,0);
             //-------------------------
             //$eti=$eti.",'".$c2."'";   
             $etp=$etp.",'".$altitud."'";
             $upres=$pre[$c2];
             $c2=$c2+$sumar;
           }
           //$var=$var.",30";
           $etp=$etp.",'".$altitud."'";
           //echo $sumar;
           $seaLevel=1013.25;
           $altitud = ((pow(($seaLevel/$upres),0.190223)-1.0)*($utem+273.15))/0.0065;
           $altitud=round($altitud,0);
           echo "Altitud ".$altitud." metros";
           $altitud=$altitud/1000;
   ?>
        </b></font></h2>
   
   <b>Temperatura</b>
   <script src="Chart.js"></script>
   <div id="canvas-holder">
      <canvas id="chart-area4" width="360" height="160"></canvas>
   </div>
   <script>
	var lineChartData = {
	labels : [<?php echo $eti; ?>],
	datasets : [
	    {
			label: "Temperatura",
			fillColor : "rgba(220,220,220,0.2)",
			strokeColor : "#6b9dfa",
			pointColor : "#1e45d7",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : [<?php echo $var; ?>]    
            //    1,3,1,4,5,5,5]
		}
	]

	}

    var ctx4 = document.getElementById("chart-area4").getContext("2d");
     window.myPie = new Chart(ctx4).Line(lineChartData, {responsive:false});
    </script>       
      
   <b>Humedad</b>
   <script src="Chart.js"></script>
   <div id="canvas-holder">
      <canvas id="chart-area5" width="360" height="160"></canvas>
   </div>
   <script>
	var lineChartData = {
	labels : [<?php echo $eth; ?>],
	datasets : [
	    {
			label: "Humedad",
			fillColor : "rgba(220,220,220,0.2)",
			strokeColor : "#6b9dfa",
			pointColor : "#1e45d7",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : [<?php echo $vah; ?>]    
            //    1,3,1,4,5,5,5]
		}
	]

	}

    var ctx5 = document.getElementById("chart-area5").getContext("2d");
    window.myPie = new Chart(ctx5).Line(lineChartData, {responsive:false});       
    </script>
    
    <b>Presión</b>
   <script src="Chart.js"></script>
   <div id="canvas-holder">
      <canvas id="chart-area6" width="360" height="160"></canvas>
   </div>
   <script>
	var lineChartData = {
	labels : [<?php echo $etp; ?>],
	datasets : [
	    {
			label: "Presion",
			fillColor : "rgba(220,220,220,0.2)",
			strokeColor : "#6b9dfa",
			pointColor : "#1e45d7",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : [<?php echo $vap; ?>]    
            //    1,3,1,4,5,5,5]
		}
	]

	}

    var ctx6 = document.getElementById("chart-area6").getContext("2d");
    window.myPie = new Chart(ctx6).Line(lineChartData, {responsive:false});       
    </script>
    </td>
    <td  valign="bottom" style="background: #FFF url(atsmosfera.jpg) ">
        <font color="#FFFF00"><b>
            KMs<br>
            </b>
        </font>
        <table>
         
        <td>
            <font color="#FFFF00"><b>
            
            30<br><br><br><br><br><br><br>
            20<br><br><br><br><br><br><br><br>
            10<br><br><br><br><br><br>
            5<br>
            4<br>
            3<br>
            2<br>
            1<br>
            0</b>
            </font>
        </td>   
        <td valign="bottom">
            <table>
                <?php
                   //$altitud=5785;
                   $altura=$altitud/30*570;
                   $altura=round($altura,0);
                ?>
               <td width=30 height=<?php echo $altura ?> bgcolor="#FF0000">
                </td>
            </table>
            
        </td>
        </table>
    </td>
    
    </table>        
</body>
</html>