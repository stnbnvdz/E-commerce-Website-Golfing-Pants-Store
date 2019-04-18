<?php if ( ! defined( 'ABSPATH' ) ) exit;

$plugin_dir_url =  plugin_dir_url( __FILE__ );
?>

<style>



.premium-box {width: 100%;}

.premium-box-head {background: #eae8e7; width: 100%; height:500px; text-align: center;}

.pho-upgrade-btn {display: block; text-align: center;}

.pho-upgrade-btn a{display: inline-block;  margin-top: 75px;}

.pho-upgrade-btn a:focus {outline: none; box-shadow: none; }

.main-heading  {text-align: center; background: #fff; margin-bottom: -70px;}

.main-heading img {margin-top: -200px;}



.premium-box-container {margin: 0 auto;}

.premium-box-container .description {text-align: center; display: block; padding: 35px 0;}

.premium-box-container .description:nth-child(odd) {background: #fff;}

.premium-box-container .description:nth-child(even) {background: #eae8e7;}



.premium-box-container .pho-desc-head {width: 768px; margin: 0 auto; position: relative;}

.premium-box-container .pho-desc-head:after {background:url(<?php echo $plugin_dir_url; ?>../assets/images/head-arrow.png) no-repeat;

 position: absolute; right: -30px; top: -6px; width: 69px; height: 98px; content: "";} 



.premium-box-container .pho-desc-head h2 {color: #02c277; font-weight: bolder; font-size: 28px; text-transform: capitalize;margin: 0 0 30px 0; line-height:35px;}

.pho-plugin-content {margin: 0 auto; width: 768px; overflow: hidden;}

.pho-plugin-content p {line-height: 32px; font-size: 18px; color: #212121; }

.pho-plugin-content img {width: auto; max-width: 100%;}

.description .pho-plugin-content ol { margin: 0; padding-left: 25px; text-align: left;}

.description .pho-plugin-content ol li {font-size: 16px; line-height: 28px; color: #212121; padding-left: 5px;}

.description .pho-plugin-content .pho-img-bg { width: 750px; margin: 0 auto; border-radius: 5px 5px 0 0; 

padding: 70px 0 40px; height: auto;}

.premium-box-container .description:nth-child(odd) .pho-img-bg {background: #f1f1f1 url(<?php echo $plugin_dir_url; ?>../assets/images/image-frame-odd.png) no-repeat 100% top;}

.premium-box-container .description:nth-child(even) .pho-img-bg {background: #f1f1f1 url(<?php echo $plugin_dir_url; ?>../assets/images/image-frame-even.png) no-repeat 100% top;}



</style>



<div class="premium-box">



    <div class="premium-box-head">

        <div class="pho-upgrade-btn">

        <a href="https://www.phoeniixx.com/product/advanced-reporting-for-woocommerce/" target="_blank"><img src="<?php echo $plugin_dir_url; ?>../assets/images/premium-btn.png" /></a>
		<a target="blank" href="http://reporting.phoeniixxdemo.com/wp-login.php?redirect_to=http%3A%2F%2Freporting.phoeniixxdemo.com%2Fwp-admin%2F&reauth=1"><img src="<?php echo $plugin_dir_url; ?>../assets/images/button2.png" /></a>
        </div>

    </div>

    <div class="main-heading"><h1><img src="<?php echo $plugin_dir_url; ?>../assets/images/premium-head.png" /></h1></div>



        <div class="premium-box-container">

				<div class="description">

                <div class="pho-desc-head"><h2>Today Summary</h2></div>

                

                    <div class="pho-plugin-content">

                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/today_summary.jpg" />

                        </div>

                    </div>

				</div> <!-- description end -->



            

            <div class="description">

                <div class="pho-desc-head"><h2>Month and Year Summary</h2></div>

                

                    <div class="pho-plugin-content">



                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/month_and_year.jpg" />

                        </div>

                    </div>

            </div> <!-- description end -->
			
			<div class="description">

                <div class="pho-desc-head"><h2>Product Summary</h2></div>

                

                    <div class="pho-plugin-content">

                    

                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/product_summary.jpg" />

                        </div>

                    </div>

            </div> <!-- description end -->
			
			
			<div class="description">

                <div class="pho-desc-head"><h2>Summary of the year</h2></div>

                

                    <div class="pho-plugin-content">

                      
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/summary_of_the_year.png" />

                        </div>

                    </div>

            </div> <!-- description end -->
			
			<div class="description">

                <div class="pho-desc-head"><h2>Order Based On Time Period</h2></div>

                

                    <div class="pho-plugin-content">


                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/order_summary.jpg" />

                        </div>

                    </div>

            </div> <!-- description end -->
			
			
			<div class="description">

                <div class="pho-desc-head"><h2>Total Sales Based On Status</h2></div>

                

                    <div class="pho-plugin-content">

                     
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/sales_order_status.jpg" />

                        </div>

                    </div>

            </div> <!-- description end -->

            <div class="description">

                <div class="pho-desc-head"><h2>Download CSV</h2>

                    <p>Summary Of The Year, Order Summary, Sales Order Status, Top Products,Top Category, Top Customer, Top Billing Country, Top Billing State,Recent Orders, Top Coupon, Top Payment Gateway In CSV Formate</p>
                    </div>

                
                    <div class="pho-plugin-content">

                     
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/csv_sheet.png" />

                        </div>

                    </div>

            </div> <!-- description end -->

            <div class="description">

                <div class="pho-desc-head"><h2>Date wise Search</h2></div>

                

                    <div class="pho-plugin-content">

                     
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/date_wise_search.jpg" />

                        </div>

                    </div>

            </div> <!-- description end -->

            <div class="description">

                <div class="pho-desc-head"><h2>Veiw Summary On Graph</h2></div>

                

                    <div class="pho-plugin-content">

                     
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/graph_img.jpg" />

                        </div>

                    </div>

            </div> <!-- description end -->

            <div class="description">

                <div class="pho-desc-head"><h2>View Instock And Out Of Stock Simple Product</h2></div>

                

                    <div class="pho-plugin-content">

                     
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/instoke_outskoke.jpg" />

                        </div>

                    </div>

            </div> <!-- description end -->

            <div class="description">

                <div class="pho-desc-head"><h2>View Instock And Out Of Stock Variable Product</h2></div>

                

                    <div class="pho-plugin-content">

                     
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/instoke_variable.jpg" />

                        </div>

                    </div>

            </div> <!-- description end -->

             <div class="description">

                <div class="pho-desc-head"><h2>Export Simple Product And Variable Product In CSV</h2></div>

                

                    <div class="pho-plugin-content">

                     
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/lessthan_img.png" />

                        </div>

                    </div>

            </div> <!-- description end -->

            <div class="description">

                <div class="pho-desc-head"><h2>View Product Based On Stock Limit</h2></div>

                

                    <div class="pho-plugin-content">

                     
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/lessthan_img2.png" />

                        </div>

                    </div>

            </div> <!-- description end -->

            <div class="description">

                <div class="pho-desc-head"><h2>You Can Expand Section</h2></div>

                

                    <div class="pho-plugin-content">

                     
                        <div class="pho-img-bg">

                        <img src="<?php echo $plugin_dir_url; ?>../assets/images/expand.jpg" />

                        </div>

                    </div>

            </div> <!-- description end -->

        </div> <!-- premium-box-container end -->

        

        <div class="pho-upgrade-btn">

			<a href="https://www.phoeniixx.com/product/advanced-reporting-for-woocommerce/" target="_blank"><img src="<?php echo $plugin_dir_url; ?>../assets/images/premium-btn.png" /></a>
			<a target="blank" href="http://reporting.phoeniixxdemo.com/wp-login.php?redirect_to=http%3A%2F%2Freporting.phoeniixxdemo.com%2Fwp-admin%2F&reauth=1"><img src="<?php echo $plugin_dir_url; ?>../assets/images/button2.png" /></a>
        </div>



</div> <!-- premium-box end -->