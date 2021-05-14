<?php
if (isset($con)){
	$id_moneda=get_id('business_profile','currency_id','id','1');
	$array_moneda=get_currency($id_moneda);
	$precision_moneda=$array_moneda['currency_precision'];
	$simbolo_moneda=$array_moneda['currency_symbol'];
	$sepador_decimal_moneda=$array_moneda['currency_decimal_separator'];
	$sepador_millar_moneda=$array_moneda['currency_thousand_separator'];
	$currency_name=$array_moneda['currency_name'];
}
?>