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
	
	//Ontengo variables pasadas por GET
	$_SESSION['sale_id']=intval($_GET['id']);
	$sale_id=$_SESSION['sale_id'];
	$sql_sale=mysqli_query($con,"select * from sales, type_documents where  sales.type=type_documents.id and sale_id='".$_SESSION['sale_id']."'");
	$count=mysqli_num_rows($sql_sale);
	$rw_sale=mysqli_fetch_array($sql_sale);
	$sale_number=$rw_sale['sale_number'];
	$sale_prefix=$rw_sale['sale_prefix'];
	$customer_id=$rw_sale['customer_id'];
	$name_document=$rw_sale['name_document'];
	$type=$rw_sale['type'];
	$seller_id=$rw_sale['seller_id'];
	$sale_by=$rw_sale['sale_by'];
	$includes_tax=$rw_sale['includes_tax'];
	$currency_id=$rw_sale['currency_id'];
	$guia_number=$rw_sale['guia_number'];
	$sql_customer=mysqli_query($con,"select * from customers where id='".$customer_id."'");
	$rw_customer=mysqli_fetch_array($sql_customer);
	$customer_name=$rw_customer['name'];
	$customer_address=$rw_customer['address1'];
	$customer_city=$rw_customer['city'];
	$customer_state=$rw_customer['state'];
	$customer_postal_code=$rw_customer['postal_code'];
	$customer_work_phone=$rw_customer['work_phone'];
	$customer_id=$rw_customer['id'];
	$tax_number=$rw_customer['tax_number'];
	$branch_id=$rw_sale['branch_id'];
	$branch_office_name=get_id('branch_offices','name','id',$branch_id);
	$branch_office_address=get_id('branch_offices','address','id',$branch_id);
	if (!isset($_GET['id']) or $count!=1){
		echo "<script>window.close();</script>";
		exit;
	}
	
	$sale_date= date('d/m/Y', strtotime($rw_sale['sale_date']));
	
	$sql_contact=mysqli_query($con,"select email from  contacts where client_id='".$customer_id."'");
	$rw_contact=mysqli_fetch_array($sql_contact);
	$customer_email=$rw_contact['email'];
	
	/*Datos de la empresa*/
		$sql_empresa=mysqli_query($con,"SELECT business_profile.number_id, business_profile.name, business_profile.tax, business_profile.address,  currencies.symbol, business_profile.city, business_profile.state, business_profile.postal_code, business_profile.phone, business_profile.email, business_profile.logo_url FROM  business_profile, currencies where business_profile.currency_id=currencies.id and business_profile.id=1");
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
	
	/*Inicio de datos de la configuracion del documento*/
		$document_format = get_id('type_documents','format','id',$type);//Obtengo el formato del documento
		$document_orientation = get_id('type_documents','orientation','id',$type);//Obtengo el formato del documento
	/*Fin datos de la configuracion del documento*/	
	
	if ($type==1){
		$document="factura.php";
		$ancho=220;
		$alto=170;
		$orientation="L";
	} else if ($type==2){
		$document="factura.php";
		$ancho=220;
		$alto=170;
		$orientation="L";
	} else if ($type==3){
		$document="ticket.php";
		$ancho=75;
		$alto=170;
		$orientation="P";
	}
	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
		

    
     include(dirname('__FILE__')."/pdf/documentos/html/".$document);
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        //$html2pdf = new HTML2PDF(array(220,170), $document_format, 'es', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf = new HTML2PDF($orientation, array($ancho,$alto), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('ventas.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
