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
	$product_id=intval($_GET['id']);
	$label_qty=intval($_GET['qty']);
	$label_width=intval($_GET['width']);
	$label_heigth=intval($_GET['height']);
	
	$query=mysqli_query($con,"select product_code, product_name from products where product_id='$product_id'");
	$row=mysqli_fetch_array($query);
	$product_name=$row['product_name'];
	$product_code=$row['product_code'];

	

	

	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
		

    
     include(dirname('__FILE__').'/pdf/documentos/html/barcode.php');
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
        $html2pdf->Output('barcode.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
