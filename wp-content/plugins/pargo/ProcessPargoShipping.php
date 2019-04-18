<?php
/**
 * Created by PhpStorm.
 * User: imtiyaazsalie
 * Date: 2018/08/13
 * Time: 11:49
 */

class ProcessPargoShipping
{

    public function postOrder($order){
        $orderFees = wc_get_order( $order->id );
        $insurance = 0;

        foreach( $orderFees->get_items('fee') as $item_id => $item_fee ){
            if ($item_fee->get_name() == 'Shipping insurance:') {
                $insurance = $item_fee->get_total();
            }
        }
        
       $orderWeight = wc_get_order($order->id);
       $totalWeight = 0;
       $parcerlCategory = 1;
       
          foreach ($orderWeight->get_items() as $item_id => $item) {
            $product = $item->get_product();
            $product_id = null;
            $product_sku = null;
            $product->get_weight();
            $itemTotalWeight = (float)$product->get_weight() * (float)$item['qty'];
            $totalWeight = $totalWeight + $itemTotalWeight;
          }
          
            if($totalWeight < 5) {
               $parcerlCategory = 1;
            }
            else if($totalWeight > 5 && $totalWeight <=10){
              $parcerlCategory = 2;
            }
            else if($totalWeight > 10){
              $parcerlCategory = 3;
            }
          

        $data = array(
            "depo" => array (
                "warehouseCode" => $_GET['warehouseCode']
            ),
            "consignee" => array (
                "firstName" => $order->data['billing']['first_name'],
                "lastName" => $order->data['billing']['last_name'],
                "phoneNumber" => $order->data['billing']['phone'],
                "mobileNumber" => $order->data['billing']['phone'],
                "email" => $order->data['billing']['email'],
                "address1" => $order->data['billing']['address_1'],
                "address2" => $order->data['billing']['address_2'],
                "suburb" => "",
                "postalCode" =>  $order->data['billing']['postcode'],
                "city" => $order->data['billing']['city'],
                "language" => "ZA"
            ),
            "delivery" => array (
                "pargoPointCode" =>  get_post_meta($order->id, 'pargo_pc', true)
            ),
            "orderdata" => array( "parcelCategory" => $parcerlCategory ),
            "transportdata" => array (
                "insurance" => (string)$insurance,
                "dimensions" => "23",
                "weight" => "1.635",
                "financialValue" => (string) $order->get_subtotal(),
                "shippersReference" => (string)$order->get_id()
            )
        );

        $data = json_encode($data);

        $ch = curl_init ("https://api.pargo.co.za/v8/orders");

        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = array(
            "Content-Type:application/json",
            "Authorization: ".get_option('woocommerce_wp_pargo_settings')['pargo_auth_token']
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
  
        if($response){
            update_post_meta( $order->id, 'pargo_waybill', ['waybill' => json_decode($response)->data->waybillNumber, 'label' => json_decode($response)->data->labelUrl ]  );
            $my_value = get_post_meta( $order->id, 'pargo_waybills', true );
            // The text for the note
            if(json_decode($response)->success == false){
                $note = __("Pargo Shipment failed ".json_decode($response)->errors[0]->detail);
                $order->add_order_note( $note );
                $order->save;
            }
            else {
                $note = __("Pargo Shipment processed.");
                $order->add_order_note( $note );
                $order->save;
            }

        }
        else{
        }

        curl_close($ch);


        $url = $_SERVER['REQUEST_URI'];
        $parsed = parse_url($url);
        $path = $parsed['path'];
        unset($_GET['ship-now']);
        if(!empty(http_build_query($_GET))){
            header("Location: ".$path .'?'. http_build_query($_GET)); //reload page

        }
    }

}
