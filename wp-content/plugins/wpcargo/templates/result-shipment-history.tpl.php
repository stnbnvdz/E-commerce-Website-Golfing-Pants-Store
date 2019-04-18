<style>
    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {

        /* Force table to not be like tables anymore */
      table#shipment-history,
      table#shipment-history thead,
      table#shipment-history tbody,
      table#shipment-history th,
      table#shipment-history td,
      table#shipment-history tr {
            display: block;
        }
        /* Hide table headers (but not display: none;, for accessibility) */
      table#shipment-history thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
      table#shipment-history tr {
            border: 1px solid #ccc;
            text-align: initial !important;

        }
      table#shipment-history td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50% !important;
            text-align: initial !important;
        }
      table#shipment-history td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }
        #wpcargo-result-print  #shipment-history tbody tr {
            background-color: #d6d6d6;
                width: 100%;
        }
        #wpcargo-result-print  #shipment-history tbody tr:nth-child(odd) {
            background-color: #f1f1f1;
        }
        /*
        Label the data
        */
      table#shipment-history td:nth-of-type(1):before { content: "<?php _e('Date.', 'wpcargo'); ?>"; }
      table#shipment-history td:nth-of-type(2):before { content: "<?php _e('Time', 'wpcargo'); ?>"; }
      table#shipment-history td:nth-of-type(3):before { content: "<?php _e('Location', 'wpcargo'); ?>"; }
      table#shipment-history td:nth-of-type(4):before { content: "<?php _e('Status', 'wpcargo'); ?>"; }
      table#shipment-history td:nth-of-type(5):before { content: "<?php _e('Remarks', 'wpcargo'); ?>"; }
      table#shipment-history td:nth-of-type(6):before { content: "<?php echo do_action('wpcargo_shipment_history_responsive_header'); ?>"; }
    }
</style>
<div id="wpcargo-history-section" class="wpcargo-history-details">
    <p class="header-title""><strong><?php _e( apply_filters( 'wpc_shipment_history_header', 'Shipment History' ), 'wpcargo'); ?></strong></p>
    <?php do_action('before_wpcargo_shipment_history', $shipment->ID) ?>
    <table id="shipment-history" class="table wpcargo-table" style="width: 100%;">
        <thead>
        <tr>
            <th><?php _e('Date','wpcargo'); ?></th>
            <th><?php _e('Time','wpcargo'); ?></th>
            <th><?php _e('Location','wpcargo'); ?></th>
            <th><?php _e('Status','wpcargo'); ?></th>
            <th><?php _e('Remarks','wpcargo'); ?></th>
            <?php do_action('wpcargo_shipment_history_header'); ?>
        </tr>
        </thead>
        <tbody>
        <?php
            $shipment_history = maybe_unserialize( get_post_meta( $shipment->ID, 'wpcargo_shipments_update', true ) );

            if(!empty($shipment_history)){
                usort($shipment_history, function( $a, $b ){
                    $t1 = strtotime($a['date'] ." ". $a['time'] );
                    $t2 = strtotime($b['date'] ." ". $b['time'] );
                    return $t1 - $t2;
                });
                foreach(array_reverse($shipment_history) as $shipments){
                    ?>
                    <tr>
                        <td><?php echo !empty($shipments['date']) ? date_i18n( get_option( 'date_format' ), strtotime( $shipments['date'] ) ) : ''; ?></td>
                        <td><?php echo !empty($shipments['time']) ? $shipments['time'] : ''; ?></td>
                        <td><?php echo $shipments['location']; ?></td>
                        <td><?php echo wpcargo_html_value( $shipments['status'] ); ?></td>
                        <td><?php echo $shipments['remarks']; ?></td>
                        <?php do_action('wpcargo_shipment_history_data', $shipments ); ?>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
    <?php do_action('after_wpcargo_shipment_history', $shipment->ID) ?>
</div>