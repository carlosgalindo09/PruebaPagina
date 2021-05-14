<?php
	if (!isset($con)){
		exit;
	}
?>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/admin.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['full_name']; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENÚ</li>
            <li class="<?php if (isset($home) and $home==1){echo "active";}?>">
              <a href="index.php">
                <i class="fa fa-home"></i> <span>Inicio</span> 
              </a>
              
            </li>
			<?php 
				permisos_menu('Compras',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
            <li class="<?php if (isset($purchases) and $purchases==1){echo "active";}?> treeview">
              <a href="#">
                <i class="fa fa-truck"></i>
                <span>Compras</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?php if (isset($purchase_add) and $purchase_add==1){echo "active";}?>"><a href="new_purchase.php"><i class="glyphicon glyphicon-shopping-cart"></i> Nueva compra</a></li>
				<li class="<?php if (isset($purchase_list) and $purchase_list==1){echo "active";}?>"><a href="purchase_list.php"><i class="glyphicon glyphicon-th-list"></i> Historial de compras</a></li>
				<li class="<?php if (isset($credit_notes_buy) and $credit_notes_buy==1){echo "active";}?>"><a href="credit_notes_buy.php"><i class="fa fa-file-text"></i> Notas de crédito</a></li>
				<li class="<?php if (isset($purchase_order) and $purchase_order==1){echo "active";}?>"><a href="purchase_order.php"><i class="fa fa-cart-plus"></i> Ordenes de compras</a></li>
			  </ul>
            </li>
			<?php } ?>
			<?php 
				permisos_menu('Cotizaciones',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
			<li class="<?php if (isset($quotes) and $quotes==1){echo "active";}?>">
              <a href="quotes.php">
                <i class="glyphicon glyphicon-briefcase"></i> <span>Cotizaciones</span>
              </a>
            </li>
			<?php } ?>
			<?php 
				permisos_menu('Ordenes',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
			<li class="<?php if (isset($service_orders) and $service_orders==1){echo "active";}?>">
              <a href="service_orders.php">
                <i class="glyphicon glyphicon-wrench"></i> <span>Ordenes de servicio</span>
              </a>
            </li>

			<?php } ?>
			<?php 
				permisos_menu('Productos',$cadena_permisos);
				$permisos_productos=$permisos_ver_menu;
				permisos_menu('Servicios',$cadena_permisos);
				$permisos_servicios=$permisos_ver_menu;
				if ($permisos_productos==1 or $permisos_servicios==1){
			?>
            <li class="<?php if (isset($catalog) and $catalog==1){echo "active";}?> treeview">
              <a href="#">
                <i class="fa fa-th-large"></i>
                <span>Catálogo</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			<?php 
				if ($permisos_productos==1){
			?>	
                <li class="<?php if (isset($inventory) and $inventory==1){echo "active";}?>"><a href="inventory.php"><i class="fa fa-file"></i> Inventario</a></li>
				<li class="<?php if (isset($products) and $products==1){echo "active";}?>"><a href="products.php"><i class="glyphicon glyphicon-barcode"></i> Productos</a></li>
			<?php } ?>
			<?php 
				if ($permisos_servicios==1){
			?>	
                <li class="<?php if (isset($services) and $services==1){echo "active";}?>"><a href="services.php"><i class="fa fa-wrench"></i> Servicios</a></li>
			<?php } ?>	
			<?php 
				permisos_menu('Fabricantes',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
				 <li class="<?php if (isset($manufacturers) and $manufacturers==1){echo "active";}?>"><a href="manufacturers.php"><i class="fa fa-tag"></i> Fabricantes</a></li>
            <?php } ?>
			
			<?php 
				permisos_menu('Categorias',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
				 <li class="<?php if (isset($categories) and $categories==1){echo "active";}?>"><a href="categories.php"><i class="fa fa-tags"></i> Categorías</a></li>
            <?php } ?>  
			  </ul>
            </li>
			<?php } ?>
			
			
			<?php 
				permisos_menu('Ajustes',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
			<li class="<?php if (isset($inventory_tweaks) and $inventory_tweaks==1){echo "active";}else {echo "";}?>">
              <a href="inventory_tweaks.php">
                <i class="fa fa-cubes"></i> <span>Ajustes de inventario</span>
              </a>
            </li>
			<?php } ?>
			<?php 
				permisos_menu('Clientes',$cadena_permisos);
				$permisos_clientes=$permisos_ver_menu;
				permisos_menu('Proveedores',$cadena_permisos);
				$permisos_proveedores=$permisos_ver_menu;
				if ($permisos_clientes==1 or $permisos_proveedores==1){
			?>
            <li class="<?php if (isset($contacts) and $contacts==1){echo "active";}?> treeview">
              <a href="#">
                <i class="fa fa-user"></i>
                <span>Contactos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			<?php 
				if ($permisos_clientes==1){
			?>	
                <li class="<?php if (isset($customers) and $customers==1){echo "active";}?>"><a href="customers.php"><i class="glyphicon glyphicon-user"></i> Clientes</a></li>
			<?php } ?>
			<?php 
				if ($permisos_proveedores==1){
			?>	
                <li class="<?php if (isset($suppliers) and $suppliers==1){echo "active";}?>"><a href="supplier.php"><i class="glyphicon glyphicon-briefcase"></i> Proveedores</a></li>
			<?php } ?>	
              </ul>
            </li>
			<?php } ?>
			<?php 
				permisos_menu('Traslados',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
			<li class="<?php if (isset($transfers) and $transfers==1){echo "active";}else {echo "";}?>">
              <a href="transfers.php">
                <i class="fa fa-arrows-h"></i> <span>Traslados</span>
              </a>
            </li>
			<?php } ?>
			
			
			<?php 
				permisos_menu('Guias',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
			<li class="<?php if (isset($referral_guides) and $referral_guides==1){echo "active";}else {echo "";}?>">
              <a href="referral_guides.php">
                <i class="fa fa-file"></i> <span>Guía de remisión</span>
              </a>
            </li>
			<?php } ?>
			
			<?php 
				permisos_menu('Egresos',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
			<li class="<?php if (isset($cash_outflows) and $cash_outflows==1){echo "active";}else {echo "";}?>">
              <a href="cash_outflows.php">
                <i class="fa fa-arrow-left"></i> <span>Egresos de caja</span>
              </a>
            </li>
			<?php } ?>
			<?php 
				permisos_menu('Cortes',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
			<li class="<?php if (isset($cashier_closing) and $cashier_closing==1){echo "active";}else {echo "";}?>">
              <a href="cashier_closing.php">
                <i class="fa fa-money"></i> <span>Cortes de caja</span>
              </a>
            </li>
			<?php 
				}
			?>
			
			<?php 
				permisos_menu('Finanzas',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
			<li class="<?php if (isset($finanzas) and $finanzas==1){echo "active";}else {echo "";}?>">
              <a href="finance.php">
                <i class="fa fa-credit-card"></i> <span>Finanzas</span>
              </a>
            </li>
			<?php 
				}
			?>
			<?php 
				permisos_menu('Ventas',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
            <li class="<?php if (isset($sales) and $sales==1){echo "active";}?> treeview">
              <a href="#">
                <i class="fa fa-dollar"></i> <span>Facturación</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?php if (isset($sale_add) and $sale_add==1){echo "active";}?>"><a href="new_sale.php"><i class="fa fa-cart-plus"></i> Nueva venta</a></li>
                <li class="<?php if (isset($sale_list) and $sale_list==1){echo "active";}?>"><a href="manage_invoice.php"><i class="glyphicon glyphicon-list-alt"></i> Administrar facturas</a></li>
				<li class="<?php if (isset($credit_notes) and $credit_notes==1){echo "active";}?>"><a href="credit_notes.php"><i class="fa fa-file-text"></i> Notas de crédito</a></li>
              </ul>
            </li>
			<?php } ?>
			<?php 
				permisos_menu('Reportes',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
            <li class="<?php if (isset($reports) and $reports==1){echo "active";}?> treeview">
              <a href="#">
                <i class="glyphicon glyphicon-signal"></i> <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
				<li class="<?php if (isset($purchases_report) and $purchases_report==1){echo "active";}?>"><a href="purchases_report.php"><i class="fa fa-line-chart"></i> Compras</a></li>
				<li class="<?php if (isset($purchases_order_report) and $purchases_order_report==1){echo "active";}?>"><a href="purchases_order_report.php"><i class="fa fa-pie-chart "></i> Ordenes de compra</a></li>
                <li class="<?php if (isset($sales_report) and $sales_report==1){echo "active";}?>"><a href="sales_report.php"><i class="fa fa-bar-chart"></i> Ventas</a></li>
				<li class="<?php if (isset($quotes_report) and $quotes_report==1){echo "active";}?>"><a href="quotes_report.php"><i class="fa fa-line-chart"></i> Cotizaciones</a></li>
				<li class="<?php if (isset($order_report) and $order_report==1){echo "active";}?>"><a href="order_report.php"><i class="fa fa-bar-chart"></i> Ordenes de servicio</a></li>
				<li class="<?php if (isset($cash_outflows_report) and $cash_outflows_report==1){echo "active";}?>"><a href="cash_outflows_report.php"><i class="fa fa-pie-chart"></i> Egresos</a></li>
				<li class="<?php if (isset($inventory_report) and $inventory_report==1){echo "active";}?>"><a href="inventory_report.php"><i class="fa fa-bar-chart"></i> Inventario</a></li>	
				<li class="<?php if (isset($stock_min_report) and $stock_min_report==1){echo "active";}?>"><a href="stock_min_report.php"><i class="fa fa-pie-chart"></i> Stock mínimo</a></li>	
			 </ul>
            </li>
			<?php } ?>
			<?php 
				permisos_menu('Configuracion',$cadena_permisos);
				$permisos_perfil=$permisos_ver_menu;
				permisos_menu('Sucursales',$cadena_permisos);
				$permisos_sucursales=$permisos_ver_menu;
				permisos_menu('Documentos',$cadena_permisos);
				$permisos_documentos=$permisos_ver_menu;
				permisos_menu('Tirajes',$cadena_permisos);
				$permisos_tirajes=$permisos_ver_menu;
				permisos_menu('Cajas',$cadena_permisos);
				$permisos_cajas=$permisos_ver_menu;
				permisos_menu('Tecnicos',$cadena_permisos);
				$permisos_tecnicos=$permisos_ver_menu;
				
				permisos_menu('Formas_pago',$cadena_permisos);
				$permisos_pagos=$permisos_ver_menu;
				
				if ($permisos_perfil=1 or $permisos_sucursales==1){
				
			?>
			
			<li class="<?php if (isset($config) and $config==1){echo "active";}else {echo "";}?> treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Configuración</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  <?php if ($permisos_perfil==1){ ?>
                <li class="<?php if (isset($business_profile) and $business_profile==1){echo "active";}else {echo "";}?>"><a href="business_profile.php"><i class="glyphicon glyphicon-briefcase"></i> Perfil de la empresa</a></li>
			  <?php }?>
				<?php if ($permisos_sucursales==1){ ?>	   
				<li class="<?php if (isset($branch_offices) and $branch_offices==1){echo "active";}else {echo "";}?>"><a href="branch_offices.php"><i class="fa fa-shopping-bag "></i> Sucursales</a></li>
				<?php }?>
				<?php if ($permisos_documentos==1){ ?>	   
				<li class="<?php if (isset($documents) and $documents==1){echo "active";}else {echo "";}?>"><a href="documents.php"><i class="fa fa-book "></i> Documentos</a></li>
				<?php }?>
				
				<?php if ($permisos_pagos==1){ ?>	   
				<li class="<?php if (isset($payment_methods) and $payment_methods==1){echo "active";}else {echo "";}?>"><a href="payment_methods.php"><i class="fa fa-file "></i> Formas de pago</a></li>
				<?php }?>
				<?php if ($permisos_tirajes==1){ ?>	   
				<li class="<?php if (isset($document_printing) and $document_printing==1){echo "active";}else {echo "";}?>"><a href="document_printing.php"><i class="fa fa-list-ol "></i> Tiraje de documentos</a></li>
				<?php }?>
				
				<?php if ($permisos_cajas==1){ ?>	   
				<li class="<?php if (isset($cashbox) and $cashbox==1){echo "active";}else {echo "";}?>"><a href="cashbox.php"><i class="fa fa-address-card "></i> Cajas</a></li>
				<?php }?>
				
				<?php if ($permisos_tecnicos==1){ ?>	   
				<li class="<?php if (isset($repairman) and $repairman==1){echo "active";}else {echo "";}?>"><a href="repairman_list.php"><i class="fa fa-users "></i> Técnicos</a></li>
				<?php }?>
              </ul>
            </li>
			
			<?php } ?>
			<?php 
				permisos_menu('Permisos',$cadena_permisos);
				$permisos_grupos=$permisos_ver_menu;
				permisos_menu('Usuarios',$cadena_permisos);
				$permisos_usuarios=$permisos_ver_menu;
				if ($permisos_grupos==1 or $permisos_usuarios==1){
			?>
			<li class="<?php if (isset($access) and $access==1){echo "active";}else {echo "";}?> treeview">
              <a href="#">
                <i class="fa fa-lock"></i> <span>Administrar accesos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			<?php 
				if ($permisos_grupos==1){
			?>  
                <li class="<?php if (isset($groups) and $groups==1){echo "active";}else {echo "";}?>"><a href="group_list.php"><i class="glyphicon glyphicon-briefcase"></i> Grupos de usuarios</a></li>
			<?php } ?>	
			<?php 
				if ($permisos_usuarios==1){
			?>
				<li class="<?php if (isset($users) and $users==1){echo "active";}else {echo "";}?>"><a href="user_list.php"><i class="fa fa-users"></i> Usuarios</a></li>
			<?php } ?>	
              </ul>
            </li>
            <?php } ?>
            <?php 
				permisos_menu('Historial',$cadena_permisos);
				if ($permisos_ver_menu==1){
			?>
			<li class="<?php if (isset($history) and $history==1){echo "active";}else {echo "";}?>">
              <a href="history.php">
                <i class="fa fa-history"></i> <span>Historial</span>
              </a>
            </li>
			<?php 
				}
			?>
           
          </ul>
        </section>
        <!-- /.sidebar -->