<?php

defined( 'ABSPATH' ) || exit;

function wpc_get_parent_product_id($product) {
    $productId = $product->get_id();

    if($product->get_parent_id()) {
        $productId = $product->get_parent_id();
    }

    return $productId;
}

function wpc_create_separate_order($order) {    
    $order_currency = $order->get_currency();
    $order_payment_gateway = $order->get_payment_method();
    
    $order_address = array(
        'first_name' => $order->get_billing_first_name(),
        'last_name'  => $order->get_billing_last_name(),
        'email'      => $order->get_billing_email(),
        'phone'      => $order->get_billing_phone(),
        'address_1'  => $order->get_billing_address_1(),
        'address_2'  => $order->get_billing_address_2(),
        'city'       => $order->get_billing_city(),
        'state'      => $order->get_billing_state(),
        'postcode'   => $order->get_billing_postcode(),
        'country'    => $order->get_billing_country()
    );

    $order_shipping = array(
        'first_name' => $order->get_shipping_first_name(),
        'last_name'  => $order->get_shipping_last_name(),
        'address_1'  => $order->get_shipping_address_1(),
        'address_2'  => $order->get_shipping_address_2(),
        'city'       => $order->get_shipping_city(),
        'state'      => $order->get_shipping_state(),
        'postcode'   => $order->get_shipping_postcode(),
        'country'    => $order->get_shipping_country()
    );

    $new_order = wc_create_order();
    $new_order->set_address( $order_address, 'billing' );
    $new_order->set_address( $order_shipping, 'shipping' );
    $new_order->set_currency( $order_currency );
    $new_order->set_payment_method( $order_payment_gateway );

    foreach ( $order->get_items() as $item_id => $item ) {
            $product = $item->get_product();
            $productId = wpc_get_parent_product_id($product);
            $separateOrder = get_post_meta($productId, '_separate_order', true);

            if($separateOrder != 'yes') {
                continue;
            }

            $product_quantity = $item->get_quantity();
            $added_item_id = $new_order->add_product( $product, $product_quantity );

            $suggestedPrice = wc_get_order_item_meta($item_id, 'suggested-price');

            if($suggestedPrice) {
                wc_add_order_item_meta( $added_item_id, 'suggested-price', $suggestedPrice );
            }

            $order->remove_item( $item_id );
    }

    $new_order->calculate_totals(); 
    $new_order->update_status( 'on-hold' );

    $order->calculate_totals();
    $order->save(); 

    if($order->get_item_count() == 0) {
        $order_id = $order->get_id(); 
        wp_delete_post($order_id, true);
    }
}


//I can explain why I used this particular hook instead of woocommerce_checkout_order_created :)
add_action( 'woocommerce_after_order_details', 'wpc_woocommerce_checkout_order_processed');
function wpc_woocommerce_checkout_order_processed( $order ) { 

    foreach ( $order->get_items() as $item_id => $item ) {
        $product = $item->get_product();
        $productId = wpc_get_parent_product_id($product);
        $separateOrder = get_post_meta($productId, '_separate_order', true);
        
        if($separateOrder == 'yes') {
            wpc_create_separate_order($order);
            return;
        }

    }
}