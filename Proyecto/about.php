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
        table#controlTable td, th {
            font-size: 1em; /*Em: Porcentaje relativo respecto del tamaño de letra del elemento.*/
            color: #ffffff;
            border: 1px outset #FFFFFF;
            padding: 3px 7px 2px 7px; /*top padding is 3px,right padding is 7px, bottom padding is 2px, left padding is 7px*/
        }
        table#controlTable th{
           text-align: center;
           padding-top: 5px; /*Padding: para controlar los espacios*/
           padding-bottom: 4px;
           background-color: #864e99;
        
        }
        .fila{
            background-color: #7a7a7a;
        }
        .fila:hover{
            background-color: #959292;
        }
        table#controlTable{
            text-align: center;
        }
        #ButtonEnviar{
           display: block;
           border: 0px;
           height: 40px;
           width: 100px;
           background-image: url("images/button_Enviar.png") ;
           background-repeat: no-repeat;
       }
       #ButtonEnviar:hover{
           background-position:0 -40px ;
       }
       input#rango_Temp{
           text-align: center;
       }
        a#logout:link,a#logout:visited{
             color: #060606;
             text-decoration: none;
        }
        a#logout:hover,a#logout:active {
          color: #C0C0C0;
       }
       .efecto-autor{
           text-align: center;
           color: #0091EA;
           font-family: Arial Black,Arial Bold,Gadget,sans-serif; 
           font-size: 2em;
       }
       .linea-autores {
          height: 2px;
          width: 64px;
          border: 0;
          background-color: #864e99;
          text-align: center;
       }
       .calendario-modificaciones{
           display: inline-block;
           border: 0px;
           height: 107px;
           width: 84px;
           background-image: url("images/calendario2.png") ;
           background-repeat: no-repeat;
       }
       .calendario-modificaciones:hover{
           background-position:-84px 0px ;
       }
       .modificaciones{
           display: inline-block;
           float: left;
           margin-left: 16px;
       }
       .texto-modificaciones{
            font-family: Arial; 
            font-size: 1em;
            color: #864e99;
            text-align: center;
       }
       .texto-modificaciones2{
           color: black;
           text-align: center;
           font-family: Arial; 
           font-size: 1em;
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
            <div display="inline-block">
                <div class="modificaciones">
                    <p class="calendario-modificaciones"></p>
                </div>
                <div class="modificaciones">
                    <h1 class="texto-modificaciones">SOFTWARE v1</h1>
                    <h1 class="texto-modificaciones2">Lautaro Gesuelli Pinto - Rodrigo Pardo</h1>
                </div>
            </div>
            <script>
                $(function () {
                    var animateClasses = 'flash bounce shake tada swing wobble pulse flip flipInX flipOutX flipInY flipOutY fadeIn fadeInUp fadeInDown fadeInLeft fadeInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig fadeOut fadeOutUp fadeOutDown fadeOutLeft fadeOutRight fadeOutUpBig fadeOutDownBig fadeOutLeftBig fadeOutRightBig bounceIn bounceInDown bounceInUp bounceInLeft bounceInRight bounceOut bounceOutDown bounceOutUp bounceOutLeft bounceOutRight rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight hinge rollIn rollOut';
                    $('.texto-modificaciones')
                    .textillate({ in: { effect: 'flash',delayScale:1.5}});
                    $('.texto-modificaciones2')
                    .textillate({ in: { effect: 'flash',shuffle: true, delayScale:0.8}}); 
                }); 
            </script>
        </section>
        <footer>
            <hr class="linea-footer">
            Copyright © 2015 - Facultad de Informática - Taller de Proyecto 2
        </footer>
    </body>
</html>
