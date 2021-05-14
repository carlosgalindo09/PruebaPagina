<?php
	/* Connect To Database*/
	include("config/db.php");
	include("config/conexion.php");
	
	//Alterar la estructura de la tabala referral_guides 10/05/2017
	$sql="ALTER TABLE `referral_guides` CHANGE `reason` `reason` VARCHAR(100) NOT NULL;";
	$query=mysqli_query($con,$sql);
