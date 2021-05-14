<?php

	// get the HTML
     ob_start();
	session_start();
	if (!isset($_SESSION['user_id'])){
			exit;
		}
	/* Connect To Database*/
	include("config/db.php");
	include("config/conexion.php");
	require_once ("libraries/inventory.php");//Contiene funcion que controla stock en el inventario
	include("currency.php");//Archivo que obtiene los datos de la moneda
	//Ontengo variables pasadas por GET
	$daterange = mysqli_real_escape_string($con,(strip_tags($_REQUEST['daterange'], ENT_QUOTES)));
	$employee_id=intval($_REQUEST['employee_id']);
	$tables="purchases_order,  users";
	$campos="*";
	$sWhere="users.user_id=purchases_order.employee_id";
	if ($employee_id>0){
		$sWhere.=" and purchases_order.employee_id = '".$employee_id."'";
	}
	if (!empty($daterange)){
		list ($f_inicio,$f_final)=explode(" - ",$daterange);//Extrae la fecha inicial y la fecha final en formato espa?ol
		list ($dia_inicio,$mes_inicio,$anio_inicio)=explode("/",$f_inicio);//Extrae fecha inicial 
		$fecha_inicial="$anio_inicio-$mes_inicio-$dia_inicio 00:00:00";//Fecha inicial formato ingles
		list($dia_fin,$mes_fin,$anio_fin)=explode("/",$f_final);//Extrae la fecha final
		$fecha_final="$anio_fin-$mes_fin-$dia_fin 23:59:59";
		
		$sWhere .= " and purchases_order.created_at between '$fecha_inicial' and '$fecha_final' ";
	}
	$sWhere.=" order by purchases_order.purchase_order_id";
	$query = mysqli_query($con,"SELECT $campos FROM  $tables where $sWhere ");
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
		

    
     include(dirname('__FILE__').'/pdf/documentos/html/purchases-order-report.php');
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
        $html2pdf->Output('usuarios.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
