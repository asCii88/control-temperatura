<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
         // define variables and set to empty values
        $name = $password = ""; 
        $error = "";

         if ($_SERVER["REQUEST_METHOD"] == "POST") {
             if (empty($_POST["name"])||(empty($_POST["password"]))) {
                 $error = "Ingresar usuario y contraseña";
             } else {
                 $name = test_input($_POST["name"]);
                 $password = test_input($_POST["password"]);
                 // check if name only contains letters and whitespace
                 
                 $conn = mysqli_connect("localhost","root","","sistema");
                 // Check connection
                 if (!$conn) {
                    //Fallo de conexion
                    die("Connection failed: " . mysqli_connect_error());
                 }
                 $userPassword = md5($password);
                 $sql="SELECT id FROM usuarios WHERE usuario='$name' AND password='$userPassword'";
                 $result=mysqli_query($conn,$sql);
                 $count=mysqli_num_rows($result);
                 // Si existe el usuario con la contraseña
                 if($count==1)
                 {
                    //Creamos sesión
                    session_start();  
                    //Almacenamos el nombre de usuario en una variable de sesión usuario
                    $_SESSION['usuario'] = $name;
                    $_SESSION['animacion'] = true;
                    //Redireccionamos a la pagina: index.php
                    header ("Location: index.php");
                 }
                 else 
                 {
                    $error="Usuario o contraseña no válidos";
                 }
            }      
        }

        function test_input($data) {
            $data = trim($data); //Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena
            $data = stripslashes($data); //Quita las barras de un string con comillas escapadas
            $data = htmlspecialchars($data); //Convierte caracteres especiales en entidades HTML
        
            return $data;
        }
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!-- Bootstrap -->
        <link href="estiloLogin.css" rel="stylesheet">
        <title>        </title>
    </head>
    <body>
        <div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Ingresar</h1>
			</div>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="login-form">
                                <div class="control-group">
                                    <input type="text" class="login-field" value="" placeholder="usuario" id="login-name" name="name" value="<?php echo $name;?>">
                                    <label class="login-field-icon fui-user" for="login-name"></label>
                                </div>

                                <div class="control-group">
                                    <input type="password" class="login-field" value="" placeholder="contraseña" id="login-pass" name="password" value="<?php echo $password;?>">
                                    <label class="login-field-icon fui-lock" for="login-pass"></label>
                                </div>
                                <h3 class="login-error"><?php echo $error;?></h3>
                                <button type="submit" class="btn btn-primary btn-large btn-block">Ingresar</button>
			</div>
                        </form>
		</div>
	</div>
    </body>
</html>
