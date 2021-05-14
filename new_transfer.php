<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}
// include the configs / constants for the database connection
require_once("config/db.php");
// load the login class
require_once("classes/Login.php");
// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();
	// ... ask if we are logged in here:
	if ($login->isUserLoggedIn() == true) 
	{	
		/* Connect To Database*/
		require_once ("config/conexion.php");
		require_once ("libraries/inventory.php");
		//Inicia Control de Permisos
		include("./config/permisos.php");
		$user_id = $_SESSION['user_id'];
		get_cadena($user_id);
		$modulo="Traslados";
		permisos($modulo,$cadena_permisos);
		//Finaliza Control de Permisos
		$title="Agregar traslado de mercadería | Inventory Control";
		$transfers=1;
		include('view/transfers/add.php');//Include file with the view
		
		
	}
	else
	{
		header("location: login.php");
		exit;		
	}
?>