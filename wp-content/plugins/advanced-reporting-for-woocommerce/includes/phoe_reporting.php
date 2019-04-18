<?php

wp_enqueue_style( 'style-advanced-reportingss',plugin_dir_url(__FILE__).'./../assets/font-awesome/css/font-awesome.min.css' );

global $wpdb,$woocommerce;

// Total Registered user	

	$phoen_user= get_users(); 
	 
	$total_registed = count($phoen_user);

//Top Products Data
	
	$phoen_top_products = array();
		$phoen_product_query = "
			SELECT  
				posts.post_title AS product_name,
				meta.meta_key as mkey, 
				meta.meta_value as product_value, 
				posts.ID AS ID
				FROM  {$wpdb->posts} AS posts
				LEFT JOIN {$wpdb->postmeta} AS meta 
					ON posts.ID = meta.post_id 
			WHERE 
				posts.post_status IN ( 'publish','private' ) 
				AND posts.post_type IN ( 'product' ) 
				AND meta.meta_key IN ( 'total_sales' ,'_price') 
			ORDER BY
				posts.ID ASC, 
				meta.meta_key ASC
		";
		$phoen_product_data = $wpdb->get_results(  $phoen_product_query,ARRAY_A);
		
		/* echo "<pre>";
		print_r($phoen_product_data);
		echo "</pre>";
		die(); */
		foreach($phoen_product_data as $key1 => $valuee){
			
			if(!isset( $phoen_top_products[$valuee['ID']])){
				
				$phoen_top_products[$valuee['ID']] = Array();
				
				$phoen_top_products[$valuee['ID']] = Array(
				
					"produc_total" => 0,
					
					"product_price" => 0,
					
					"product_count" => 0,
					
					"product_views" => 0
					
				);
			
			}
			
			switch ($valuee['mkey']) {
				
				case "_price":
					
					$phoen_top_products[$valuee['ID']]["product_price"] = $valuee['product_value'];
					
					break;
				
				case "total_sales":
				
					$phoen_top_products[$valuee['ID']]["product_count"] += $valuee['product_value'];
					
					$phoen_top_products[$valuee['ID']]["produc_total"] += (is_numeric($valuee['product_value'])?$valuee['product_value']:0)* (is_numeric($phoen_top_products[$valuee['ID']]["product_price"])?$phoen_top_products[$valuee['ID']]["product_price"]:0);
					
					$phoen_top_products[$valuee['ID']]["product_name"] = $valuee['product_name'];
					
					$phoen_top_products[$valuee['ID']]["ID"] = $valuee['ID'];
					
					break;
					
				default:
				
					break;
					
			}
		
		}
	
		function phoen_products_short($a, $b) {
			return $a['product_count'] < $b['product_count'];
		}
		
			
		
		usort($phoen_top_products, "phoen_products_short");
		
		
		 
	 $phoen_totle_sale_products='0';
		
		for($i=0; $i<count($phoen_product_data); $i++)
		{
			if($phoen_product_data[$i]['mkey']=='total_sales')
			{
				
				$phoen_totle_sale_products+=$phoen_product_data[$i]['product_value'];
				
			}
			
		}
		
//Coupan Data 

	$phoen_coupan_query = "
		SELECT  
			posts.post_title AS coupan_name, 
			posts.ID AS coupan_id, 
			meta.meta_value AS coupan_amount, 
			cmeta.meta_value AS coupan_count
			FROM  {$wpdb->posts} AS posts
			LEFT JOIN {$wpdb->postmeta} AS meta 
				ON posts.ID = meta.post_id 
			LEFT JOIN {$wpdb->postmeta} AS cmeta 
				ON posts.ID = cmeta.post_id 
		WHERE 
			meta.meta_key = 'coupon_amount'
			AND cmeta.meta_key = 'usage_count'
			AND posts.post_type = 'shop_coupon'
			AND posts.post_status IN ( 'publish' )
	";
	$phoen_coupon_data = $wpdb->get_results(  $phoen_coupan_query,ARRAY_A);

	function phoen_coupan_short($a, $b) {
			return $a['coupan_count'] < $b['coupan_count'];
		}
		
		usort($phoen_coupon_data, "phoen_coupan_short");
	
	
	
//Category Data
	
	$phoen_category_query = "
			SELECT  
				posts.post_title AS product_name,
				meta.meta_value * pmeta.meta_value as total_amount, 
				pmeta.meta_value as totle_products, 
				meta.meta_value as total_sale_count, 
				terms.name as category_name, 
				terms.term_id as category_id, 
				posts.ID AS product_ID
				FROM  {$wpdb->posts} AS posts
				LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id 
				LEFT JOIN {$wpdb->postmeta} AS pmeta ON(posts.ID = pmeta.post_id)
				LEFT JOIN {$wpdb->term_relationships} AS rel ON(posts.ID = rel.object_id)
				LEFT JOIN {$wpdb->term_taxonomy} AS taxo ON(rel.term_taxonomy_id = taxo.term_taxonomy_id)
				LEFT JOIN {$wpdb->terms} AS terms ON(taxo.term_id = terms.term_id)
			WHERE 
				posts.post_status IN ( 'publish','private' ) 
				AND posts.post_type IN ( 'product' ) 
				AND meta.meta_key IN ( 'total_sales' ) 
				AND pmeta.meta_key IN ( '_price') 
				AND taxo.taxonomy IN ( 'product_cat' ) 
			ORDER BY
				posts.ID ASC
		";
		$phoen_cat_data = $wpdb->get_results(  $phoen_category_query,ARRAY_A);
		
		$phoen_all_cat_data=array();
		
		foreach($phoen_cat_data as $kes => $phoen_category_values)
		{
			if(!isset( $phoen_all_cat_data[$phoen_category_values['category_id']])){

				$phoen_all_cat_data[$phoen_category_values['category_id']] = Array(
				
				"total_amount" => 0,
				
				"total_sale_counts" => 0,
				
				"category_names" => $phoen_category_values['category_name'],
				
				"category_ids" => $phoen_category_values['category_id']
				
				);
				
			}	
			
			$phoen_all_cat_data[$phoen_category_values['category_id']]["total_sale_counts"] += $phoen_category_values['total_sale_count'];
			
			$phoen_all_cat_data[$phoen_category_values['category_id']]["total_amount"] += (is_numeric($phoen_category_values['total_sale_count'])?$phoen_category_values['total_sale_count']:0) * (is_numeric($phoen_category_values['totle_products'])?$phoen_category_values['totle_products']:0);
		
		}
		
		function phoen_category_shorts($a, $b) {
				
			return $a['total_sale_counts'] < $b['total_sale_counts'];
			
		}
		
			usort($phoen_all_cat_data, "phoen_category_shorts");  
		

//Top Billing State & Top Billing Country & Top Payment Method Data
		
		
		$phoen_billing_country_querys = "
			SELECT 
				first_name_meta.meta_value as first_name,
				last_name_meta.meta_value as last_name,
				posts.post_status as ordr_status,  
				billing_amount_meta.meta_value as billing_amount,  
				billing_state_meta.meta_value as billing_state,  
				pay_method_meta.meta_value as pay_method,  
				payment_method_title_meta.meta_value as payment_method_title,  
				billing_email_meta.meta_value as billing_email,
				billing_country_meta.meta_value as billing_country,  
				posts.ID AS ID
				
				FROM    {$wpdb->posts} AS posts
				LEFT JOIN {$wpdb->postmeta} AS first_name_meta ON(posts.ID = first_name_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS last_name_meta ON(posts.ID = last_name_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS billing_amount_meta ON(posts.ID = billing_amount_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS billing_country_meta ON(posts.ID = billing_country_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS billing_state_meta ON(posts.ID = billing_state_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS payment_method_title_meta ON(posts.ID = payment_method_title_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS pay_method_meta ON(posts.ID = pay_method_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS billing_email_meta ON(posts.ID = billing_email_meta.post_id)
			WHERE 
				posts.post_status LIKE 'wc-%' 
				AND posts.post_type IN ( 'shop_order' ) 
				AND billing_amount_meta.meta_key IN ( '_order_total')
				AND billing_country_meta.meta_key IN ( '_billing_country')
				AND billing_state_meta.meta_key IN ( '_billing_state')
				AND pay_method_meta.meta_key IN ( '_payment_method')
				AND payment_method_title_meta.meta_key IN ( '_payment_method_title')
				AND last_name_meta.meta_key IN ( '_billing_last_name')
				AND first_name_meta.meta_key IN ( '_billing_first_name')
				AND billing_email_meta.meta_key IN ( '_billing_email')
			ORDER BY
				posts.ID ASC
		";
		$phoen_Billing_data = $wpdb->get_results(  $phoen_billing_country_querys,ARRAY_A);
		
		
		$phoen_billings_countrys=array();
		
		$phoen_billings_states=array();
		
		$phoen_payment_method=array();
		
		$phoen_order_status=array();
		
		$phoen_top_customer=array();
		
		foreach($phoen_Billing_data as $ky=>$billing_data)
		{
			
			if(!isset( $phoen_billings_countrys[$billing_data['billing_country']])){
				
				$phoen_billings_countrys[$billing_data['billing_country']] = Array(
				
					"total_amount" =>0,
					
					"totle_order_counts" => 0,
					
					"country_name" =>$billing_data['billing_country']
				
				);
			}	
			if(!isset( $phoen_billings_states[$billing_data['billing_state']])){
				
				$phoen_billings_states[$billing_data['billing_state']] = Array(
				
					"total_amount" =>0,
					
					"totle_order_counts" => 0,
					
					"state_name" =>$billing_data['billing_state']
				
				);
				
			}

			if(!isset( $phoen_payment_method[$billing_data['pay_method']])){
				
			
				$phoen_payment_method[$billing_data['pay_method']] = Array(
				
					"total_amount" => 0,
					
					"totle_order_counts" => 0,
					
					"payment_name" => $billing_data['payment_method_title']
				
				);
				
			}
			
			
			if(!isset( $phoen_order_status[$billing_data['ordr_status']])){
				
			
				$phoen_order_status[$billing_data['ordr_status']] = Array(
				
					"total_amount" => 0,
					"order_Statuss"=>$billing_data['ordr_status']
					
				);
				
			}
			
			if(!isset( $phoen_top_customer[$billing_data['billing_email']])){
				
				$phoen_top_customer[$billing_data['billing_email']] = Array(
				
					"total_customer_amoun" => 0,
					
					"totle_cust_order_count" => 0,
					
					"customer_fname" => $billing_data['first_name'],
					
					"customer_lname" => $billing_data['last_name'],
					
					"customer_email" => $billing_data['billing_email']
					
				);
				
			} 
			
			$phoen_billings_countrys[$billing_data['billing_country']]["totle_order_counts"] += 1;
			$phoen_billings_countrys[$billing_data['billing_country']]["total_amount"] += $billing_data['billing_amount'];
			
			
			$phoen_billings_states[$billing_data['billing_state']]["totle_order_counts"] += 1;
			$phoen_billings_states[$billing_data['billing_state']]["total_amount"] += $billing_data['billing_amount'];
			
			
			$phoen_payment_method[$billing_data['pay_method']]["totle_order_counts"] += 1;
			$phoen_payment_method[$billing_data['pay_method']]["total_amount"] += $billing_data['billing_amount'];
			
			
			$phoen_order_status[$billing_data['ordr_status']]["total_amount"] += $billing_data['billing_amount'];
			
			$phoen_top_customer[$billing_data['billing_email']]["totle_cust_order_count"] += 1;
			$phoen_top_customer[$billing_data['billing_email']]["total_customer_amoun"] += $billing_data['billing_amount'];
			
		
		}
		
		function phoen_country_short($c, $d) {
			return $c['totle_order_counts'] < $d['totle_order_counts'];
		}
		
		usort($phoen_billings_countrys, "phoen_country_short");
	
		function phoen_state_short($e, $f) {
			return $e['totle_order_counts'] < $f['totle_order_counts'];
		}
		
		usort($phoen_billings_states, "phoen_state_short");
		
		
		function phoen_payment_short($g, $h) {
			return $g['totle_order_counts'] < $h['totle_order_counts'];
		}
		
		usort($phoen_payment_method, "phoen_payment_short");
		
		function phoen_customer_short($g, $h) {
			return $g['total_customer_amoun'] < $h['total_customer_amoun'];
		}
		
		usort($phoen_top_customer, "phoen_customer_short"); 

//Recent Order Data

		 $phoen_recent_order_querys = "
			SELECT 
				first_name_meta.meta_value as first_name,
				last_name_meta.meta_value as last_name,
				posts.post_status as ordr_status,  
				tmeta.meta_value as billing_amount,  
				billing_email_meta.meta_value as billing_email,
				cart_discount_meta.meta_value as cart_discount,
				order_tex_meta.meta_value as order_tex,
				order_shipping_tax_meta.meta_value as order_shipping_tax,
				order_shipping_meta.meta_value as order_shipping,
				customer_user_meta.meta_value as customer_user,
				posts.post_date as order_date,
				posts.ID AS ID
				
				FROM    {$wpdb->posts} AS posts
				LEFT JOIN {$wpdb->postmeta} AS tmeta ON(posts.ID = tmeta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS first_name_meta ON(posts.ID = first_name_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS last_name_meta ON(posts.ID = last_name_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS billing_email_meta ON(posts.ID = billing_email_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS cart_discount_meta ON(posts.ID = cart_discount_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS order_tex_meta ON(posts.ID = order_tex_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS order_shipping_tax_meta ON(posts.ID = order_shipping_tax_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS order_shipping_meta ON(posts.ID = order_shipping_meta.post_id)
				LEFT JOIN {$wpdb->postmeta} AS customer_user_meta ON(posts.ID = customer_user_meta.post_id)
			WHERE 
				posts.post_status IN ('wc-completed','wc-on-hold','wc-cancelled','wc-refunded','wc-failed','wc-pending','wc-processing')
				AND posts.post_type IN ( 'shop_order' ) 
				AND tmeta.meta_key IN ( '_order_total')
				AND last_name_meta.meta_key IN ( '_billing_last_name')
				AND first_name_meta.meta_key IN ( '_billing_first_name')
				AND billing_email_meta.meta_key IN ( '_billing_email')
				AND cart_discount_meta.meta_key IN ( '_cart_discount')
				AND order_tex_meta.meta_key IN ( '_order_tax')
				AND order_shipping_tax_meta.meta_key IN ( '_order_shipping_tax')
				AND order_shipping_meta.meta_key IN ( '_order_shipping')
				AND customer_user_meta.meta_key IN ( '_customer_user')
				
			ORDER BY
				posts.ID DESC
		";
		$phoen_recent_order_datas = $wpdb->get_results(  $phoen_recent_order_querys,ARRAY_A);
	
		
// Total Tax & Total Coupan Amount & Total Customers User Data

	$phoen_all_tax='0';	
	$phoen_ord_tax='0';	
	$phoe_ship_tax='0';
	$phoen_toatal_cupan_amount='0';
	
	$phoen_guest_user=0;
	
	$totle_billing_amount='0';
	
	$phoen_order_rf_counts='0';
	
	$totle_billing_amountt='0';
	
	$pho_order_ship='0';
	
	$totle_billing_refunds_amoun='0';
	
	$pho_order_shipr='0';
	$phoen_ord_taxr='0';
	$phoe_ship_taxr='0';
	$phoen_toatal_cupan_amountt='0';
	$phoen_totle_year_amount='0';
	
	for($i=0; $i<count($phoen_recent_order_datas); $i++)
	{
		
	
		$pho_order_ship+=$phoen_recent_order_datas[$i]['order_shipping'];
		$phoen_ord_tax+=$phoen_recent_order_datas[$i]['order_tex'];
		$phoe_ship_tax+=$phoen_recent_order_datas[$i]['order_shipping_tax'];
		
		$phoen_toatal_cupan_amount+=$phoen_recent_order_datas[$i]['cart_discount'];
		
		
		$phoen_all_tax=$phoen_ord_tax+$phoe_ship_tax;
		
		if($phoen_recent_order_datas[$i]['customer_user']==0)
		{
			$phoen_guest_user++;
		}
		
		if($phoen_recent_order_datas[$i]['ordr_status']!='wc-refunded')   //Totle Sale Amount
		{
			if($phoen_recent_order_datas[$i]['ordr_status']!='wc-cancelled')
			{
				
				$totle_billing_amount+=$phoen_recent_order_datas[$i]['billing_amount'];
			
			}
		}
		
		 if($phoen_recent_order_datas[$i]['ordr_status'] == 'wc-refunded' || $phoen_recent_order_datas[$i]['ordr_status'] == 'wc-cancelled')
		{
			$phoen_order_rf_counts+=count($phoen_recent_order_datas[$i]['ID']);
	
		} 
		
		 if($phoen_recent_order_datas[$i]['ordr_status'] != 'wc-refunded' || $phoen_recent_order_datas[$i]['ordr_status'] != 'wc-cancelled')
		{
			$totle_billing_amountt+=$phoen_recent_order_datas[$i]['billing_amount'];
			
		}
		
		 if($phoen_recent_order_datas[$i]['ordr_status'] != 'wc-refunded' || $phoen_recent_order_datas[$i]['ordr_status'] != 'wc-cancelled')
		{
			$pho_order_shipr+=$phoen_recent_order_datas[$i]['order_shipping'];
			$phoen_ord_taxr+=$phoen_recent_order_datas[$i]['order_tex'];
			$phoe_ship_taxr+=$phoen_recent_order_datas[$i]['order_shipping_tax'];
			$phoen_toatal_cupan_amountt+=$phoen_recent_order_datas[$i]['cart_discount'];
		}
	
		
	} 
	
	$phoen_month= date("m");
	
	$phoen_totle_gross_sale=($totle_billing_amount/$phoen_month);
	
	$total_sale_amount =  number_format((float)$phoen_totle_gross_sale, 2, '.', '');
	
	$phoe_totles=($pho_order_shipr+$phoen_ord_taxr+$phoe_ship_taxr);
	
	$phoe_prices=$totle_billing_amount-$phoe_totles;
	
	$phoen_net_sales=$phoe_prices/$phoen_month;
	
	$phoen_net_sale =  number_format((float)$phoen_net_sales, 2, '.', '');
	
/****** Total Average Gross Monthly Sales & Last Day**********/	
	
	$phoe_order_by_date_query = "
			SELECT  
				YEAR(posts.post_date) AS year, 
				MONTH(posts.post_date) AS month,
				DAY(posts.post_date) AS day,
				date(posts.post_date) as order_date,
				posts.post_type as type,
				posts.post_status as ordr_status, 
				meta.meta_key as mkey, 
				SUM(meta.meta_value) AS total_amount, 
				1 AS projtotal, 
				COUNT(posts.ID) AS totle_order_counts 
				FROM  {$wpdb->posts} AS posts
				LEFT JOIN {$wpdb->postmeta} AS meta 
					ON posts.ID = meta.post_id 
			WHERE 
				posts.post_status LIKE 'wc-%'
				AND meta.meta_key IN ( '_cart_discount' ,'_order_total' ,'_order_tax' ,'_order_shipping_tax' ,'_order_shipping' ,'_customer_user', '_refund_amount' ) 
			GROUP BY 
				YEAR(posts.post_date), 
				MONTH(posts.post_date) ,
				DAY(posts.post_date) ,
				date(posts.post_date),
				posts.post_type,
				meta.meta_key 
			ORDER BY
				YEAR(posts.post_date), 
				MONTH(posts.post_date), 
				DAY(posts.post_date),
				date(posts.post_date)
				ASC
		";
		$phoen_totle_day_data = $wpdb->get_results(  $phoe_order_by_date_query,ARRAY_A);
		
		$phe_datas=1.11;
		$phoen_total_orders='0';
		$phoen_total_amounss='0';
		
		$phoen_yesterday_orders='0';
		$phoen_yesterday_amounss='0';
		
		
		foreach($phoen_totle_day_data as $phoe_vals)
		{
			$current_date= date("Y-m-d");
			
			if($phoe_vals['order_date']==$current_date)
			{
				
				if($phoe_vals['mkey'] == '_order_total')
				{
					$phoen_total_orders+=$phoe_vals['totle_order_counts'];
				
					$phoen_total_amounss+=$phoe_vals['total_amount'];
				}
				
			}
			
			$phoen_date=date('d-m-Y',strtotime("-1 days"));
			
			if($phoe_vals['order_date']==$phoen_date)
			{
				$phoen_yesterday_orders+=$phoe_vals['totle_order_counts'];
				
				$phoen_yesterday_amounss+=$phoe_vals['total_amount'];
			}
		
		}


	
	
	
	?>
	
	<div class="phoe-war">
		<div class="phoe-report-wrap">
		<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="phoe-war-coupns">
						 <ul class="nav nav-tabs">
							<h2><?php _e( 'Total Summary', 'advanced-reporting-for-woocommerce' ); ?></h2>
						</ul>
						 
						<div class="tab-content">
								<div id="home"  class="tab-pane fade in active">
								
									<div class="col-sm-4 col-xs-12 phoe-war-top-sec-padd">
										<div class="phoe-war-top-sec">
											<div class="phoe-war-top-sec-load">
												<span class="fa fa-money"></span>
											</div>
											<div class="phoe-war-top-sec-text">
												<h1><?php _e( 'Total Sales', 'advanced-reporting-for-woocommerce' ); ?></h1>
												<span><?php
												
													echo get_woocommerce_currency_symbol().($totle_billing_amount);?>
												
												</span>
											</div>
										</div>
									</div>
									<div class="col-sm-4 col-xs-12 phoe-war-top-sec-padd">
										<div class="phoe-war-top-sec">
											<div class="phoe-war-top-sec-load">
												<span class="fa fa-tags"></span>
											</div>
											<div class="phoe-war-top-sec-text">
												<h1><?php _e( 'Total Refund', 'advanced-reporting-for-woocommerce' ); ?></h1>
												<span>
												  
													<?php 
													
														echo get_woocommerce_currency_symbol().(isset($phoen_order_status['wc-refunded']['total_amount'])?$phoen_order_status['wc-refunded']['total_amount']:0);
													
													?>
												
												</span>
											</div>
										</div>
									</div>
									<div class="col-sm-4 col-xs-12 phoe-war-top-sec-padd">
										<div class="phoe-war-top-sec">
											<div class="phoe-war-top-sec-load">
												<span class="fa fa-tags"></span>
											</div>
											<div class="phoe-war-top-sec-text">
												<h1><?php _e( 'Total Tax', 'advanced-reporting-for-woocommerce' ); ?></h1>
												<span>
												
													<?php
														 $phoe_stotal_tax_add=isset($phoen_all_tax)?$phoen_all_tax:'';

													echo get_woocommerce_currency_symbol().($phoe_stotal_tax_add);?>
												
												</span>
											</div>
										</div>
									</div>
									<div class="col-sm-4 col-xs-12 phoe-war-top-sec-padd">
										<div class="phoe-war-top-sec">
											<div class="phoe-war-top-sec-load">
												<span class="fa fa-line-chart"></span>
											</div>
											<div class="phoe-war-top-sec-text">
												<h1><?php _e( 'Total Coupons', 'advanced-reporting-for-woocommerce' ); ?></h1>
												<span>
												
												
													<?php

													$phoe_scupan_total=isset($phoen_toatal_cupan_amount)?$phoen_toatal_cupan_amount:'';
													
													echo get_woocommerce_currency_symbol().($phoe_scupan_total);?>
													
												</span>
											
											</div>
										</div>
									</div>
									<div class="col-sm-4 col-xs-12 phoe-war-top-sec-padd">
										<div class="phoe-war-top-sec">
											<div class="phoe-war-top-sec-load">
												<span class="fa fa-tags"></span>
											</div>
											<div class="phoe-war-top-sec-text">
												<h1><?php _e( 'Total Registered', 'advanced-reporting-for-woocommerce' ); ?></h1>
												<span>
												
													<?php 
													   
													   $phoe_stotal_registed=isset($total_registed)?$total_registed:'';
													
														echo $phoe_stotal_registed; ?>
												
												</span>
											</div>
										</div>
									</div>
									<div class="col-sm-4 col-xs-12 phoe-war-top-sec-padd">
										<div class="phoe-war-top-sec">
											<div class="phoe-war-top-sec-load">
												<span class="fa fa-pie-chart"></span>
											</div>
											<div class="phoe-war-top-sec-text">
												<h1><?php _e( 'Total Guest Customers', 'advanced-reporting-for-woocommerce' ); ?></h1>
												<span>
												
													<?php 
													
														$phoen_sguest_user=isset($phoen_guest_user)?$phoen_guest_user:'';
														
														
														echo $phoen_sguest_user;

													?>
												
												</span>
											</div>
										</div>
									</div>
									
									<div class="col-sm-4 col-xs-12 phoe-war-top-sec-padd">
										<div class="phoe-war-top-sec">
											<div class="phoe-war-top-sec-load">
												<span class="fa fa-pie-chart"></span>
											</div>
											<div class="phoe-war-top-sec-text">
												<h1><?php _e( 'Total Average Gross Monthly Sales ', 'advanced-reporting-for-woocommerce' ); ?></h1>
												<span>
												
													<?php 
													
														echo get_woocommerce_currency_symbol().($total_sale_amount);
													?>
												
												</span>
											</div>
										</div>
									</div>
									
									<div class="col-sm-4 col-xs-12 phoe-war-top-sec-padd">
										<div class="phoe-war-top-sec">
											<div class="phoe-war-top-sec-load">
												<span class="fa fa-pie-chart"></span>
											</div>
											<div class="phoe-war-top-sec-text">
												<h1><?php _e( 'Total Average Net Monthly Sales ', 'advanced-reporting-for-woocommerce' ); ?></h1>
												<span>
												
													<?php 
													
															echo get_woocommerce_currency_symbol().($phoen_net_sale+$phe_datas);
													?>
												
												</span>
											</div>
										</div>
									</div>
									
									<div class="col-sm-4 col-xs-12 phoe-war-top-sec-padd">
										<div class="phoe-war-top-sec">
											<div class="phoe-war-top-sec-load">
												<span class="fa fa-pie-chart"></span>
											</div>
											<div class="phoe-war-top-sec-text">
												<h1><?php _e( 'Total Items Purchased ', 'advanced-reporting-for-woocommerce' ); ?></h1>
												<span>
												
													<?php 
													
														echo ($phoen_totle_sale_products-$phoen_order_rf_counts);
													?>
												
												</span>
											</div>
										</div>
									</div>
									
									
									
							</div>
						</div>
					</div>
				
			</div>
			
			<div class="col-sm-6 col-xs-12 phoe-war-ear-main">
						<div class="phoe-war-ear-sec-head">
							<h2><?php _e( 'Order Today', 'advanced-reporting-for-woocommerce' ); ?></h2>
						</div>
						<div class="phoe-war-ear-sec">
							<span class="fa fa-shopping-cart"></span>
							<h3><?php echo $phoen_total_orders; ?></h3>
							<p><?php _e( 'New Orders', 'advanced-reporting-for-woocommerce' ); ?></p>
						</div>
						<div class="phoe-war-last">
							<p><?php _e( 'Last Day:', 'advanced-reporting-for-woocommerce' ); ?><span><?php echo $phoen_yesterday_orders; ?></span></p>
						</div>
			</div>
			<div class="col-sm-6 col-xs-12 phoe-war-ear-main">
				<div class="phoe-war-ear-sec-head">
					<h2><?php _e( 'Earnings Today', 'advanced-reporting-for-woocommerce' ); ?></h2>
				</div>
				<div class="phoe-war-ear-sec">
					<span class="fa fa-usd"></span>
					<h3><?php echo get_woocommerce_currency_symbol().($phoen_total_amounss);?></h3>
					<p><?php _e( 'Earning', 'advanced-reporting-for-woocommerce' ); ?></p>
				</div>
				<div class="phoe-war-last">
					<p><?php _e( 'Last Day:', 'advanced-reporting-for-woocommerce' ); ?> <span><?php echo get_woocommerce_currency_symbol().($phoen_yesterday_amounss);?></span></p>
				</div>
			</div>

				</div>
				
				<div class="row">
					
					
					
					<div class="col-sm-6 col-xs-12 phoe-war-top-tens-main">
					
					<div class="panel-group">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" href="#collapse1"><?php _e( 'Top Products', 'advanced-reporting-for-woocommerce' ); ?>
									<span class="fa fa-caret-down"></span>
								</a>
								</h4>
							</div>
						

							<div id="collapse1" class="panel-collapse collapse in">
								<table class="table table-striped table-bordered">
									<thead>
									  <tr>
										<th><?php _e( 'Product Name', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th><?php _e( 'Qty', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th><?php _e( 'Amount', 'advanced-reporting-for-woocommerce' ); ?></th>
									  </tr>
									</thead>
									<tbody>
									<?php
									
									for($i=0; $i<count($phoen_top_products); $i++)
									{
								
										?>
										<tr>
											<td>
											
												<?php $phoen_product_title=isset($phoen_top_products[$i]['product_name'])?$phoen_top_products[$i]['product_name']:'';
												
												echo $phoen_product_title; ?> 
												
											</td>
											
											<td>
											
												<?php 
												
													$phoen_product_quentity=isset($phoen_top_products[$i]['product_count'])?$phoen_top_products[$i]['product_count']:'';     
												
													echo $phoen_product_quentity; 
											
												?>
											
											</td>
											
											<td>
												<?php 
												
												$phoen_total_product_price=isset($phoen_top_products[$i]['produc_total'])?$phoen_top_products[$i]['produc_total']:'';
												
													echo get_woocommerce_currency_symbol().($phoen_total_product_price);
												
												?>
											</td>
											
										
										</tr>	
										
										<?php
										
									}
	 
									 ?>
									
									</tbody>
								
								</table>
							
							</div>
						
						</div>
					
					</div>
					
				</div>
				
				<div class="col-sm-6 col-xs-12 phoe-war-top-tens-main">
				<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse2"><?php _e( 'Top Category', 'advanced-reporting-for-woocommerce' ); ?> <span class="fa fa-caret-down"></span></a>
							</h4>
						</div>

						<div id="collapse2" class="panel-collapse collapse in">
							<div class="tab-content">
								<div id="homett7" class="tab-pane fade in active">
								  <table class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th><?php _e( 'Category Name', 'advanced-reporting-for-woocommerce' ); ?></th>
											<th><?php _e( 'Qty', 'advanced-reporting-for-woocommerce' ); ?></th>
											<th><?php _e( 'Amount', 'advanced-reporting-for-woocommerce' ); ?></th>
										  </tr>
										</thead>
										<tbody>
											
													<?php 
													
													for($i=0; $i<count($phoen_all_cat_data); $i++)
													{
														?>
														<tr>
															<td>
															<?php
																
																$pho_cat_name=isset($phoen_all_cat_data[$i]['category_names'])?$phoen_all_cat_data[$i]['category_names']:'';
																
																echo $pho_cat_name;
															?>
															</td>
														
															<td>
																<?php
																
																$phoe_sale_counts=isset($phoen_all_cat_data[$i]['total_sale_counts'])?$phoen_all_cat_data[$i]['total_sale_counts']:'';
																echo $phoe_sale_counts;
																?>
															</td>
															
															<td>
																<?php 
																
																$pho_totale_sale_amount=isset($phoen_all_cat_data[$i]['total_amount'])?$phoen_all_cat_data[$i]['total_amount']:'';
															
																echo get_woocommerce_currency_symbol().($pho_totale_sale_amount);
															
																?>
															</td>
														
														</tr>
														
													<?php
													}
													
													?>
												
										</tbody>
									</table>
								</div>
								<div id="menutt8" class="tab-pane fade">
									<div id="chart_tc"></div>
								</div>
								
								<div id="menutt9" class="tab-pane fade">
									<div id="chart_tc2"></div>
								</div>
							</div>
						</div>
				</div>
				</div>
					
					
				</div>
				
				
			<div class="row">
				
				
				<div class="col-sm-12 col-xs-12 phoe-war-top-tens-main">
				
					<div class="panel panel-default phoe-top-ten-customers">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse2"><?php _e( 'Top Customer', 'advanced-reporting-for-woocommerce' ); ?>
								<span class="fa fa-caret-down"></span>
							</a>
							</h4>
						</div>
						
						<div id="collapse3" class="panel-collapse collapse in">
							<table class="table table-striped table-bordered">
								<thead>
								  <tr>
									<th width="30%" ><?php _e( 'Billing Name', 'advanced-reporting-for-woocommerce' ); ?></th>
									<th width="30%" ><?php _e( 'Billing Email', 'advanced-reporting-for-woocommerce' ); ?></th>
									<th width="20%" ><?php _e( 'Order Count', 'advanced-reporting-for-woocommerce' ); ?></th>
									<th width="20%" ><?php _e( 'Amount', 'advanced-reporting-for-woocommerce' ); ?></th>
								  </tr>
								</thead>
								<tbody>
							
									<?php  
											foreach($phoen_top_customer as $ksy=>$phoen_top_customers)
											{ 
												
												?>		
													<tr>
														<td><?php echo$phoen_top_customers['customer_fname']."-".$phoen_top_customers['customer_lname']; ?></td>
														<td><?php echo $phoen_top_customers['customer_email'];?></td>
														<td><?php echo $phoen_top_customers['totle_cust_order_count'];?></td> 
														<td><?php echo get_woocommerce_currency_symbol().$phoen_top_customers['total_customer_amoun'];?></td>
														
													</tr>
													
												<?php
													
											}   
									
										?>  
		
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
			</div>
			
				<div class="row">
					<div class="col-sm-6 col-xs-12 phoe-re-top-ten-cntry-state">
						<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse7"><?php _e( 'Top Billing Country', 'advanced-reporting-for-woocommerce' ); ?>  <span class="fa fa-caret-down"></span></a>
									</h4>
								</div>
							

								<div id="collapse7" class="panel-collapse collapse in">
								  <table class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th><?php _e( 'Billing Country', 'advanced-reporting-for-woocommerce' ); ?></th>
											<th><?php _e( 'Order Count', 'advanced-reporting-for-woocommerce' ); ?></th>
											<th><?php _e( 'Amount', 'advanced-reporting-for-woocommerce' ); ?></th>
										  </tr>
										</thead>
										<tbody>
										
											<?php 
												foreach($phoen_billings_countrys as $kky=>$phoen_billings_countryss)
												{
													?>
													<tr>
														<td>
														
															<?php
																
																$phoeni_country_name=isset($phoen_billings_countryss['country_name'])?$phoen_billings_countryss['country_name']:'';
															
																echo $phoeni_country_name;
															?>
															
														</td>
														
														<td>
														
															<?php 
																
																$phoeni_totale_order=isset($phoen_billings_countryss['totle_order_counts'])?$phoen_billings_countryss['totle_order_counts']:'';
																
																echo $phoeni_totale_order;
																
															?>
														
														</td>
														
														<td>
														
															<?php 
															
																$phoeni_totle_amounts=isset($phoen_billings_countryss['total_amount'])?$phoen_billings_countryss['total_amount']:'';
																
																echo get_woocommerce_currency_symbol().($phoeni_totle_amounts);
															
															?>
														
														</td>
													
													</tr>
													
													<?php 
												} 
											
											?>
											
										</tbody>
									</table>
								</div>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12 phoe-re-top-ten-cntry-state">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a data-toggle="collapse" href="#collapse4"><?php _e( 'Top Billing State', 'advanced-reporting-for-woocommerce' ); ?><span class="fa fa-caret-down"></span></a>
								</h4>
							</div>
						

							<div id="collapse4" class="panel-collapse collapse in">
							  <table class="table table-striped table-bordered">
									<thead>
									  <tr>
										<th><?php _e( 'Billing State', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th><?php _e( 'Order Count', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th><?php _e( 'Amount', 'advanced-reporting-for-woocommerce' ); ?></th>
									  </tr>
									</thead>
									<tbody>
									<?php
									foreach($phoen_billings_states as $kyy => $phoen_billings_statess)
									{
										
										?>
										<tr>
											<td>
												<?php echo $phoen_billings_statess['state_name']; ?>
											</td>
											
											<td>
												<?php echo $phoen_billings_statess['totle_order_counts']; ?>
											</td>
											
											<td>
												<?php echo $phoen_billings_statess['total_amount']; ?>
											</td>
											
										</tr>
										
										<?php
								
									}
									 
									?>								
									</tbody>
								
								</table>
							</div>
						</div>
					</div>
				</div>
			
		<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="phoe-war-latest-prjct-main">
						<div class="phoe-war-latest-prjct-head">
							<h2><?php _e( 'Recent Orders', 'advanced-reporting-for-woocommerce' ); ?></h2>
						</div>
						<div class="phoe-war-ear-sec">
						<div id="collapse8" class="panel-collapse collapse in ">
							<table class="table table-striped table-bordered widefat">
									<thead>
									  <tr>
										<th width="50px"><?php  _e( 'Order ID', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="100px"><?php _e( 'Name', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="100px"><?php _e( 'Email', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php  _e( 'Date', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="60px"><?php  _e( 'Status', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php  _e( 'Gross Amt.', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php  _e( 'Order Discount Amt.', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php  _e( 'Total Discount Amt.', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php _e( 'Shipping Amt.', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php _e( 'Shipping Tax Amt.', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php _e( 'Order Tax Amt.', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php  _e( 'Total Tax Amt.', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php _e( 'Part Refund Amt.', 'advanced-reporting-for-woocommerce' ); ?></th>
										<th width="55px"><?php _e( 'Net Amt.', 'advanced-reporting-for-woocommerce' ); ?></th>
									  </tr>
									</thead>
									<tbody>
									
									<?php
									
										for($i=0; $i<count($phoen_recent_order_datas); $i++)
										{
										
											?>
											<tr>
											
												<td><?php echo $phoen_recent_order_datas[$i]['ID'];?></td>
												
												<td><?php echo $phoen_recent_order_datas[$i]['first_name']." ".$phoen_recent_order_datas[$i]['last_name'];?></td>
											
												<td><?php echo $phoen_recent_order_datas[$i]['billing_email'];?></td>
												
												<td><?php echo $phoen_recent_order_datas[$i]['order_date'];?></td>
												
												<td>
												
												<?php 
														$status="";
														
													if($phoen_recent_order_datas[$i]['ordr_status']=="wc-cancelled")
													{
														
														$status="Cancelled";
														
														?>
														<mark class="phoen_canclled"><?php echo $status; ?></mark>
														<?php
													}
													if($phoen_recent_order_datas[$i]['ordr_status']=="wc-processing")
													{
														
														$status="Processing";
														?>
														<mark class="phoen_processing"><?php echo $status; ?></mark>
														<?php
														
													}
													if($phoen_recent_order_datas[$i]['ordr_status']=="wc-completed")
													{
														
														$status="Completed";
														
														?>
														<mark class="phoen_completed"><?php echo $status; ?></mark>
														<?php
													}
													if($phoen_recent_order_datas[$i]['ordr_status']=="wc-on-hold")
													{
														
														$status="On-hold";
														
														?>
														<mark class="phoen_holds"><?php echo $status; ?></mark>
														<?php
													}
													if($phoen_recent_order_datas[$i]['ordr_status']=="wc-refunded")
													{
														
														$status="Refunded";
														
														?>
														<mark class="phoen_refunded"><?php echo $status; ?></mark>
														<?php
													} 
												
												?>
												
												</td>
												
												<td><?php echo get_woocommerce_currency_symbol().($phoen_recent_order_datas[$i]['billing_amount']-$phoen_recent_order_datas[$i]['order_shipping_tax']-$phoen_recent_order_datas[$i]['order_tex']-$phoen_recent_order_datas[$i]['order_shipping']-$phoen_recent_order_datas[$i]['cart_discount']);?></td>
												
												<td><?php echo get_woocommerce_currency_symbol().$phoen_recent_order_datas[$i]['cart_discount'];?></td>
												
												<td><?php echo get_woocommerce_currency_symbol().$phoen_recent_order_datas[$i]['cart_discount'];?></td>
												
												<td><?php echo get_woocommerce_currency_symbol().$phoen_recent_order_datas[$i]['order_shipping'];?></td>
												
												<td><?php echo get_woocommerce_currency_symbol().$phoen_recent_order_datas[$i]['order_shipping_tax'];?></td>
												
												<td><?php echo get_woocommerce_currency_symbol().$phoen_recent_order_datas[$i]['order_tex'];?></td>
												
												<td><?php echo get_woocommerce_currency_symbol().($phoen_recent_order_datas[$i]['cart_discount']+$phoen_recent_order_datas[$i]['order_shipping']+$phoen_recent_order_datas[$i]['order_shipping_tax']+$phoen_recent_order_datas[$i]['order_tex']);?></td>
												
												<td>
												
													<?php 
														
														if($phoen_recent_order_datas[$i]['ordr_status']=='wc-refunded')
														{
															echo get_woocommerce_currency_symbol().($phoen_recent_order_datas[$i]['billing_amount']);
														}else{
															
															echo get_woocommerce_currency_symbol().'0';
														}
													?>
												
												
												
												</td>
												
												<td>
												
													<?php 
												
													if($phoen_recent_order_datas[$i]['ordr_status']=='wc-refunded')
													{
														echo get_woocommerce_currency_symbol().'0';
													}else{
														
														echo get_woocommerce_currency_symbol().($phoen_recent_order_datas[$i]['billing_amount']); 
			
													}
													?>
												
												</td>
												
												
											</tr>
											
											
											<?php	
										}
										 
									?>
									
									</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="phoe-war-coupns">
						<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse5"><?php _e( 'Top Coupon', 'advanced-reporting-for-woocommerce' ); ?> <span class="fa fa-caret-down"></span></a>
									</h4>
								</div>
							

								<div id="collapse5" class="panel-collapse collapse in">
								  <table class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th><?php _e( 'Coupon Code', 'advanced-reporting-for-woocommerce' ); ?></th>
											<th><?php _e( 'Coupon Count', 'advanced-reporting-for-woocommerce' ); ?></th>
											<th><?php _e( 'Amount', 'advanced-reporting-for-woocommerce' ); ?></th>
										  </tr>
										</thead>
										<tbody>
											<?php
											
											foreach($phoen_coupon_data as $kys => $phoen_coupon_datas)
											{
												?>
													<tr>
														<td>
															
															<?php echo $phoen_coupon_datas['coupan_name']; ?>
													
														</td>
														
														<td>
														
															<?php echo $phoen_coupon_datas['coupan_count'];?>
							
														</td>
														
														<td>
														
															<?php echo get_woocommerce_currency_symbol().(($phoen_coupon_datas['coupan_amount'])*($phoen_coupon_datas['coupan_count'])); ?>

														</td>
														
													</tr>
												
												<?php
												
											}
										
											?>
										</tbody>
									</table>
								</div>
						</div>
					</div>
				</div>
				
				<div class="col-sm-6 col-xs-12">
					<div class="phoe-war-coupns">
						<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse6"><?php _e( 'Top Payment Gateway', 'advanced-reporting-for-woocommerce' ); ?> <span class="fa fa-caret-down"></span></a>
									</h4>
								</div>
							

								<div id="collapse6" class="panel-collapse collapse in">
								  <table class="table table-striped table-bordered">
										<thead>
										  <tr>
											<th width="46%"><?php _e( 'Payment Method', 'advanced-reporting-for-woocommerce' ); ?></th>
											<th><?php _e( 'Order Count', 'advanced-reporting-for-woocommerce' ); ?></th>
											<th><?php _e( 'Amount', 'advanced-reporting-for-woocommerce' ); ?></th>
										  </tr>
										</thead>
										<tbody>
										<?php
										
										foreach($phoen_payment_method as $key => $valuees)
										{
										
											?>
											
											<tr>
											
												<td>
												
													<?php echo $valuees['payment_name']; ?>
												
												</td>
												
												<td>
												
													<?php echo $valuees['totle_order_counts']; ?>
												
												</td>
												
												<td>
												
													<?php echo get_woocommerce_currency_symbol().($valuees['total_amount']); ?>
												
												</td>
											
											</tr>
											
											<?php
										 
										}
										 
										
										?>
										</tbody>
									</table>
								</div>
						</div>
					</div>
				</div>
				
			</div>
			
		
	
	</div>
<script>
jQuery(document).ready(function(){
	jQuery(".panel-heading").click(function(){ 
				jQuery('#accordion .panel-heading').not(this).removeClass('isOpen');
				jQuery(this).toggleClass('isOpen');
				jQuery(this).next(".panel-collapse").addClass('thePanel');
				jQuery('#accordion .panel-collapse').not('.thePanel').slideUp("fast"); 
		    	jQuery(".thePanel").slideToggle("fast").removeClass('thePanel'); 
			});
})

</script>	