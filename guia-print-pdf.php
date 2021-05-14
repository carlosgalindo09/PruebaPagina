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
	$referral_guide_id=intval($_GET['referral_guide_id']);
	//Final variables GET
	$sql=mysqli_query($con,"select * from referral_guides where id='".$referral_guide_id."'");
	$count=mysqli_num_rows($sql);
	$rw=mysqli_fetch_array($sql);
	$currency_id=$rw['currency_id'];
	$number=$rw['number'];
	$created_at=date('d/m/Y',strtotime($rw['created_at']));
	$branch_id=$rw['branch_id'];
	$customer_id=$rw['customer_id'];
	$address1=get_id('customers','address1','id',$customer_id);
	$city=get_id('customers','city','id',$customer_id);
	$state=get_id('customers','state','id',$customer_id);
	$sender_address=get_id('branch_offices','address','id',$branch_id);
	$receiver_address="$address1";
	$reason=$rw['reason'];
	if (!empty($city)){
		$receiver_address.=", $city";
	} 
	if (!empty($state)){
		$receiver_address.=", $state";
	}
	$receiver=get_id('customers','name','id',$customer_id);
	$transport=$rw['transport'];
	$includes_tax=$rw['includes_tax'];
	$carrier=$rw['carrier'];
	
	$comprobante=$rw['comprobante'];
	
	if (!isset($_GET['referral_guide_id']) or $count!=1){
		exit;
	}
	
	
	
	
	
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
		

    
     include(dirname('__FILE__').'/pdf/documentos/html/guia.php');
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
