<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../../libraries/password_compatibility_library.php");
}		
if (empty($_POST['fullname'])){
			$errors[] = "Nombres vacíos";
		}   elseif (empty($_POST['user_email'])) {
            $errors[] = "El correo electrónico no puede estar vacío";
        } elseif (strlen($_POST['user_email']) > 64) {
            $errors[] = "El correo electrónico no puede ser superior a 64 caracteres";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Su dirección de correo electrónico no está en un formato de correo electrónico válida";
        } elseif (
			!empty($_POST['fullname'])
			&& !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
        ) {
			require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
			// escaping, additionally removing everything that could be (html/javascript-) code
                $fullname = mysqli_real_escape_string($con,(strip_tags($_POST["fullname"],ENT_QUOTES)));
				$user_email = mysqli_real_escape_string($con,(strip_tags($_POST["user_email"],ENT_QUOTES)));
				
				list($user,$mail)=explode("@",$user_email);
				$user_name=$user;
				//Generar pass aleatorio
				 $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
				 $maxlength = strlen($possible);
				 $length=8;
				 $i = 0;
				$password="";
				 while ($i < $length) { 
				  // pick a random character from the possible ones
				  $char = substr($possible, mt_rand(0, $maxlength-1), 1);
				  // have we already used this character in $password?
				  if (!strstr($password, $char)) { 
					// no, so it's OK to add it onto the end of whatever we've already got...
					$password .= $char;
					// ... and increase the counter by one
					$i++;
				  }
				 }
				
				//Fin pass aleatorio
				
				
				$user_password = $password;
				
				$user_group_id=1;
				$status=1;
				$date_added=date("Y-m-d H:i:s");
                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
				$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
				// check if user or email address already exists
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
                $query_check_user_name = mysqli_query($con,$sql);
				$query_check_user=mysqli_num_rows($query_check_user_name);
                if ($query_check_user == 1) {
                    $errors[] = "Lo sentimos , el nombre de usuario ó la dirección de correo electrónico ya está en uso.";
                } else {
					// write new user's data into database
                    $sql = "INSERT INTO users (fullname, user_name, user_password_hash, user_email, date_added,user_group_id, status)
                            VALUES('".$fullname."','" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "','".$date_added."','".$user_group_id."','".$status."');";
                    $query_new_user_insert = mysqli_query($con,$sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
						$mensaje="URL: <a href='http://obedalvarado.pw/premium/allcontrol/login.php' target='_blank'> http://obedalvarado.pw/premium/allcontrol/login.php</a><br>";
						$mensaje.="Usuario: $user_email <br>";
						$mensaje.="Contraseña: $password";
                        mail($user_email, 'Datos de tu cuenta', $mensaje);
						
						
                        $messages[] = "La cuenta ha sido creada con éxito. Hemos enviado en correo electrónico con los datos de acceso al sistema";
                    } else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
                    }
                }
			
		}else {
			$errors[] = "Error desconocido";	
		}	 
	

if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}
?>			