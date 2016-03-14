<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php session_start();
       if(!isset($_SESSION['usuario'])) 
        {
            header('Location: login.php'); 
            exit();
        }
    ?>
    <head>
        <meta charset="UTF-8">
        <META HTTP-EQUIV='refresh' CONTENT='5'> <!-- Recarga de pagina modelo push, cada 5s-->
        <title>        </title>
        <style>
        header {
           background-color:#864e99;
           border-top-left-radius: 5px;
           border-top-right-radius: 5px;
           color:white;
           text-align:center;
           padding:5px; 
        }
       nav {
           background-color: #909090;
           overflow: hidden;
       }
       footer {
           background-color:#C0C0C0;
           color:#000000;
           text-align:center;
           padding-top: 10px;
           padding-bottom: 10px;
           border-bottom-left-radius: 8px;
           border-bottom-right-radius: 8px;
       }
       linea-footer{
          height: 2px;
          width: 480px;
          border: 0;
          background-color: #864e99;
          text-align: center;
       }
       /*a:link Es el estilo de un enlace que no ha sido explorado por el usuario. 
         a:visited Es el estilo de un enlace que ha sido visitado. 
         a:active Estilo de un enlace seleccionado, mientras está siendo seleccionado.
         a:hover Es el estilo de un enlace que tiene el ratón encima, pero sin estar seleccionado*/
       ul#menu a:hover,ul#menu a:active {
          background-color: #C0C0C0;
       }
       ul#menu a:link,a:visited{
            display: block;
            width: 120px;
            font-weight: bold;
            color: #FFFFFF;
            background-color: #909090;
            text-align: center;
            padding: 4px;
            text-decoration: none;
            text-transform: uppercase;
       }
       ul#menu li {
           float: left;
       }
       ul#menu{
         list-style-type: none;
         margin: 0;
         padding: 0;
       }
       div#menuLogout{
           margin-right: 24px;
           margin-top: 4px;
           margin-bottom: 4px;
           float:right;
       }
       section#contenedor {
           background-color: #C0C0C0;
           padding-top: 8px;
           padding-left: 12px;
           padding-right: 12px;
           height: 500px;
       }
       div#Header{
           margin-bottom: 8px;
           border-top-left-radius: 5px;
           border-top-right-radius: 5px;
           border-bottom-left-radius: 5px;
           border-bottom-right-radius: 5px;
           border-width: 1px;	
           border-style:solid;
           border-color: #909090;
           background-color: #864e99;
           padding-left: 4px;
           padding-top: 2px;
           padding-bottom: 2px;
       }
       .classHeader h2{
           display: block;
           color: #FFFFFF;
           font-size: 1em;
           margin-top: 0;
           margin-bottom: 0;
           margin-left: 0;
           margin-right: 0;
       }
       div#Sensor{
           display: block;
           margin-top: 0;
           margin-bottom: 8px;
           margin-right: 4px;
           border-top-left-radius: 2px;
           border-top-right-radius: 2px;
           border-width:2px;	
           border-style:outset;
           border-color: #FFFFFF;
           padding-left: 4px;
           padding-top: 4px;
           padding-bottom: 4px;
           background:  #5bc0de;//linear-gradient(45deg, rgba(0,149,172,1) 0%, rgba(0,190,200,1) 100%);
           width: 270px;
       }
       div#Sensor:hover{
           background:rgba(0,190,200,1);
       }
       h2.sensorTitulo{
           display: block;
           color: white;
           font-size: 1.2em;
           margin-top: 0;
           margin-bottom: 0;
           margin-left: 0;
           margin-right: 0;
       }
       .classHeader estado{
           display: block;
           float: left;
       }
       #ancho{
           float:right;
       } 
       span.celcius {
           display: inline-block;
        }
       span.degree-symbol {
           display: inline-block;
        }
        p.temperaturaGrados{
            display: block;
            font-family: serif;
            font-style: normal;
            font-weight: 300;
            font-size: 3.5em;
            color: #FFFFFF;
            margin: 0;
        }
        p.temperaturaLetras{
            display: block;
            font-family: serif;
            font-style: normal;
            font-weight: 300;
            font-size: 1em;
            color: #FFFFFF;
            margin: 0;
        }
        div.temperatura{
            display:inline-block;
        }
        p.potenciaUnit{
            display: block;
            font-family: serif;
            font-style: normal;
            font-weight: 300;
            font-size: 3.5em;
            color: #FFFFFF;
            margin: 0;
        }
        p.potenciaLetras{
            display: block;
            font-family: serif;
            font-style: normal;
            font-weight: 300;
            font-size: 1em;
            color: #FFFFFF;
            margin: 0;
        }
        div.potencia{
            display:inline-block;
            border-left-style: solid;
            border-left-color: white;
            padding: 6px;
        }
        div.menu1{
            display:inline-block;
        }
        a#logout:link,a#logout:visited{
             color: #060606;
             text-decoration: none;
        }
        a#logout:hover,a#logout:active {
          color: #C0C0C0;
       }
        </style>
    </head>
    <body>
        <link href="textillate/assets/animate.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="textillate/assets/jquery.fittext.js"></script>
        <script src="textillate/assets/jquery.lettering.js"></script>
        <script src="http://yandex.st/highlightjs/7.3/highlight.min.js"></script>
        <script src="textillate/jquery.textillate.js"></script>
        <header>
              <h1 class="efecto-autor">Sistema de control de temperatura</h1>
        </header>
        <nav>
            <div>
            <ul id="menu">
                <li><a href="/Proyecto/index.php">HOME</a></li>
                <li><a href="/Proyecto/control.php">CONTROL</a></li>
                <li><a href="/Proyecto/about.php">ABOUT</a></li>    
            </ul>
            </div>
            <div id="menuLogout">
                <a href="/Proyecto/logout.php" id="logout">Salir</a>
            </div>
        </nav>
        <section id="contenedor">
      
            <ul id="menu">
            <?php
                // Create connection
                $conn = mysqli_connect("localhost","root","","sistema");
       
                // Check connection
                if (!$conn) {
                    //Fallo de conexion
                    die("Connection failed: " . mysqli_connect_error());
                }
                    //Conexion correcta
       
                    $sql = "SELECT id,tempact,estado,potencia FROM estado";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($line = mysqli_fetch_assoc($result)) {
                            if($line["estado"] == 1){
                                echo"<li>";
                                echo"<div id='Sensor'>";
                                echo"    <h2 class='sensorTitulo'>Ambiente ". htmlspecialchars($line['id']) ."</h2>";
                                echo"    <div class='temperatura'>";
                                echo"    <p class='temperaturaGrados'>". htmlspecialchars($line['tempact']) ."";
                                echo"    <span class='degree-symbol'>°</span><span class='celcius'>C</span>";
                                echo"    </p>";
                                echo"    <p class='temperaturaLetras'>Temperatura</p>";
                                echo"    </div>";
                                echo"    <div class='potencia'>";
                                echo"    <p class='potenciaUnit'>". htmlspecialchars($line['potencia']) ."";
                                echo"    </p>";
                                echo"    <p class='potenciaLetras'>Potencia</p>";
                                echo"    </div>";
                                echo"</div>";
                                echo"    </li>";
                            }
                        }
                    }
                    mysqli_close($conn);//Close the connection
            ?>           
            </ul>
            <script>
                $(function () {
                     var animateClasses = 'flash bounce shake tada swing wobble pulse flip flipInX flipOutX flipInY flipOutY fadeIn fadeInUp fadeInDown fadeInLeft fadeInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig fadeOut fadeOutUp fadeOutDown fadeOutLeft fadeOutRight fadeOutUpBig fadeOutDownBig fadeOutLeftBig fadeOutRightBig bounceIn bounceInDown bounceInUp bounceInLeft bounceInRight bounceOut bounceOutDown bounceOutUp bounceOutLeft bounceOutRight rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight hinge rollIn rollOut';
                    $('.efecto-autor')
                    .textillate({ in: { effect: 'flash',delayScale:0.4}}); 
                });
            </script>
        </section>
        <footer>
            <hr class="linea-footer">
            Copyright © 2015 - Facultad de Informática - Taller de Proyecto 2
        </footer>
    </body>
</html>