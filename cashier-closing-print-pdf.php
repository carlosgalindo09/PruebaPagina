<?php

	session_start();
	// get the HTML
     ob_start();
	 if (!isset($_SESSION['user_id'])){
			exit;
		}
	/* Connect To Database*/
	include("config/db.php");
	include("config/conexion.php");
	require_once ("libraries/inventory.php");//Contiene funcion que controla stock en el inventario
	include("libraries/fechas.php");
	include("currency.php");//Archivo que obtiene los datos de la moneda
	//Ontengo variables pasadas por GET
	$user_id=$_SESSION['user_id'];
	$fondo_fijo=floatval($_GET['fondo_fijo']);

	/*Inicio carga de datos*/
		$id_sucursal = get_id('cashbox','branch_id','user_id',$user_id);//Obtengo el id de la sucursal
		$nombre_sucursal = get_id('branch_offices','name','id',$id_sucursal);//Obtengo el nombre de la sucursal
		$id_sucursal=intval($id_sucursal );
		$cashbox_id=get_id('cashbox','id','user_id',$user_id);	
		$opening_balance=get_id('cashbox','opening_balance','id',$cashbox_id);
		$date_initial=get_id('cashbox','last_close','id',$cashbox_id);	
		$date_final=date("Y-m-d H:i:s");	
		$total_ingresos=total_ingresos($date_initial,$date_final,$user_id);
		$total_cobros=total_cobros($date_initial,$date_final,$cashbox_id);
		$fullname=get_id('users','fullname','user_id',$user_id);
		//include("currency.php");//Archivo que obtiene los datos de la moneda
	/*Fin carga de datos*/

	/*Guardo el corte*/
		
		guardar_corte($date_initial, $date_final, $opening_balance, $fondo_fijo, $user_id, $cashbox_id, $id_sucursal );
		save_log('Cortes de caja','Registro de corte de caja',$_SESSION['user_id']);
	/*Fin almacenamiento de corte*/
	
	/*Datos de la empresa*/
		$sql_empresa=mysqli_query($con,"SELECT business_profile.name, business_profile.tax, business_profile.address,  currencies.symbol, business_profile.city, business_profile.state, business_profile.postal_code, business_profile.phone, business_profile.email, business_profile.logo_url FROM  business_profile, currencies where business_profile.currency_id=currencies.id and business_profile.id=1");
		$rw_empresa=mysqli_fetch_array($sql_empresa);
		$moneda=$rw_empresa["symbol"];
		$tax=$rw_empresa["tax"];
		$bussines_name=$rw_empresa["name"];
		$address=$rw_empresa["address"];
		$city=$rw_empresa["city"];
		$state=$rw_empresa["state"];
		$postal_code=$rw_empresa["postal_code"];
		$phone=$rw_empresa["phone"];
		$email=$rw_empresa["email"];
		$logo_url=$rw_empresa["logo_url"];
		
	/*Fin datos empresa*/

		
	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
		

    
     include(dirname('__FILE__').'/pdf/documentos/html/corte.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('corte.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
