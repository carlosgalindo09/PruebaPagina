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
	include("currency.php");//Archivo que obtiene los datos de la moneda
	include("classes/numberToLetter.php");//Clase que se usará para convertir numero a letras
	//Ontengo variables pasadas por GET
	$quote_id=intval($_GET['quote_id']);
	//Final variables GET
	$sql=mysqli_query($con,"select * from quotes where quote_id='".$quote_id."'");
	$count=mysqli_num_rows($sql);
	$rw=mysqli_fetch_array($sql);
	$quote_date= date('d/m/Y', strtotime($rw['quote_date']));
	$customer_id=$rw['customer_id'];
	$employee_id=$rw['employee_id'];
	$note=$rw['note'];
	$terms=$rw['terms'];
	$validity=$rw['validity'];
	$delivery=$rw['delivery'];
	$quote_status=$rw['status'];
	$currency_id=$rw['currency_id'];
	$sql_customer=mysqli_query($con,"select * from customers where id='".$customer_id."'");
	$rw_customer=mysqli_fetch_array($sql_customer);
	$customer_name=$rw_customer['name'];
	$customer_address=$rw_customer['address1'];
	$customer_city=$rw_customer['city'];
	$customer_state=$rw_customer['state'];
	$customer_postal_code=$rw_customer['postal_code'];
	$customer_work_phone=$rw_customer['work_phone'];
	$customer_id=$rw_customer['id'];
	
	if (!isset($_GET['quote_id']) or $count!=1){
		exit;
	}
	
	
	
	$sql_contact=mysqli_query($con,"select * from customers, contacts where customers.id=contacts.client_id and client_id='".$customer_id."'");
	$rw_contact=mysqli_fetch_array($sql_contact);
	$customer_name=$rw_contact['name'];
	$customer_phone=$rw_contact['work_phone'];
	$contact_name=$rw_contact['first_name']." ".$rw_contact['last_name'];
	$contact_phone=$rw_contact['phone'];
	$contact_email=$rw_contact['email'];
	
	/*Datos de la empresa*/
		$sql_empresa=mysqli_query($con,"SELECT business_profile.name, business_profile.industry, business_profile.tax, business_profile.address,  currencies.symbol, business_profile.city, business_profile.state, business_profile.postal_code, business_profile.phone, business_profile.email, business_profile.logo_url, business_profile.number_id FROM  business_profile, currencies where business_profile.currency_id=currencies.id and business_profile.id=1");
		$rw_empresa=mysqli_fetch_array($sql_empresa);
		$moneda=$rw_empresa["symbol"];
		$tax=$rw_empresa["tax"];
		$bussines_name=$rw_empresa["name"];
		$industry=$rw_empresa['industry'];
		$address=$rw_empresa["address"];
		$city=$rw_empresa["city"];
		$state=$rw_empresa["state"];
		$postal_code=$rw_empresa["postal_code"];
		$phone=$rw_empresa["phone"];
		$email=$rw_empresa["email"];
		$logo_url=$rw_empresa["logo_url"];
		$number_id=$rw_empresa["number_id"];
	/*Fin datos empresa*/

	/* datos de la moneda*/
	$array_moneda=get_currency($currency_id);
	$precision_moneda=$array_moneda['currency_precision'];
	$simbolo_moneda=$array_moneda['currency_symbol'];
	$sepador_decimal_moneda=$array_moneda['currency_decimal_separator'];
	$sepador_millar_moneda=$array_moneda['currency_thousand_separator'];
	$currency_name=$array_moneda['currency_name'];
	/*Fin datos moneda*/
	
	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
		

    
     include(dirname('__FILE__').'/pdf/documentos/html/cotizacion.php');
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
        $html2pdf->Output('cotizacion.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
