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
	include("libraries/inventory.php");
	include("classes/numberToLetter.php");//Clase que se usará para convertir numero a letras
	//Ontengo variables pasadas por GET
	$purchase_order_id=intval($_GET['purchase_order_id']);
	//Final variables GET
	$sql=mysqli_query($con,"select * from purchases_order where purchase_order_id='".$purchase_order_id."'");
	$count=mysqli_num_rows($sql);
	$rw=mysqli_fetch_array($sql);
	$created_at=date("d/m/Y", strtotime($rw['created_at']));
	$supplier_id=$rw['supplier_id'];
	$employee_id=$rw['employee_id'];
	$terms=$rw['terms'];
	$ship_via=$rw['ship_via'];
	$note=$rw['note'];
	$includes_tax=$rw['includes_tax'];
	$currency_id=$rw['currency_id'];
	list ($id_proveedor, $fecha_creado,$nombre_proveedor, $direccion_proveedor, $ciudad_proveedor, $estado_direccion, $codigo_postal_proveedor,$codigo_ciudad_proveeedor, $telefono_proveedor,$sitio_web_proveedor, $tax_proveedor) = get_data("suppliers",'id',$supplier_id); //datos del proveedor
	
	list ($id_contacto,$id_proveedor_contacto,$nombres_contacto, $apellidos_contacto, $email_contacto, $telefono_contacto)=get_data("contacts_supplier","supplier_id",$supplier_id);//Datos del contacto
	
	list($user_id, $fullname,$dat3,$dat4, $user_email)=get_data("users","user_id",$employee_id);//Datos del usuario
	
	if (!isset($_GET['purchase_order_id']) or $count!=1){
		exit;
	}
	
	

	
	/*Datos de la empresa*/
		$sql_empresa=mysqli_query($con,"SELECT business_profile.name, business_profile.industry, business_profile.tax, business_profile.address,  currencies.symbol, business_profile.city, business_profile.state, business_profile.postal_code, business_profile.phone, business_profile.email, business_profile.logo_url FROM  business_profile, currencies where business_profile.currency_id=currencies.id and business_profile.id=1");
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
		

    
     include(dirname('__FILE__').'/pdf/documentos/html/orden_compra.php');
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
        $html2pdf->Output('Orden_Compra.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
