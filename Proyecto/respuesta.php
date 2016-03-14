<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <META HTTP-EQUIV='refresh' CONTENT='5; url=/Proyecto/index.php'> <!-- Redirige a los 5s a HOME-->
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
           background:  linear-gradient(45deg, rgba(0,149,172,1) 0%, rgba(0,190,200,1) 100%);
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
        <header>
              <h1>Sistema de control de temperatura</h1>
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
             <?php
                // Create connection
                $conn = mysqli_connect("localhost","root","","sistema");
       
                // Check connection
                if (!$conn) {
                    //Fallo de conexion
                    die("Connection failed: " . mysqli_connect_error());
                }
                    /*Conexion correcta TODO
                    Cantidad de sensores es la cantidad de filas de la tabla de estados
                    Dependiendo de esa cantidad es lo que hay que guardar
                    mysqli_num_rows($result)*/
                    $cantSensores = $_POST["cant_Sensores"];
                    for($id = 1;$id<($cantSensores+1);$id++){                   
                       $estado = $_POST["estado_Sensor$id"];
                       $rango =  $_POST["rango_Sensor$id"];
                       $sql = "UPDATE control SET tempdes=$rango,estado=$estado,modificado='1' WHERE id=$id";
                       if ($conn->query($sql) === TRUE) {
                          //Actualizacion exitosa 
                       } else {
                          //Error en la actualizacion
                       }
                    }
                    mysqli_close($conn);//Close the connection
            ?>      

           <p>Espere por favor, será redireccionado en 5 segundos. Si tu navegador no te redirige automáticamente puedes acceder haciendo click </p>
           <a href='/Proyecto/index.php'>HOME</a>
        </section>
        <footer>
            <hr class="linea-footer">
            Copyright © 2015 - Facultad de Informática - Taller de Proyecto 2
        </footer>
    </body>
</html>