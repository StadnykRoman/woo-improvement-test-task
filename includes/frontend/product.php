<?php

defined( 'ABSPATH' ) || exit;

add_action('woocommerce_before_add_to_cart_button', function(){

    echo '<div class="suggested-price-container">';
        woocommerce_form_field('suggested-price', array(
            'type' => 'number',
            'class' => array( 'form-row-wide') ,
            'label' => __('Offer your price per product unit') ,
            'custom_attributes' => array( 'step' => 'any', 'min' => '0' ),
            'required' => false,
        ) , '');
    echo '</div>';
    ?>

    <?php
}, 30);

add_filter( 'woocommerce_add_cart_item_data', 'add_product_price_to_cart_item_data', 20, 2 );
function add_product_price_to_cart_item_data( $cart_item_data, $product_id ){

    if( isset($_POST['suggested-price']) && ! empty($_POST['suggested-price']) ){
        $suggestedPrice = sanitize_textarea_field( $_POST['suggested-price'] );
        $cart_item_data['suggested-price'] = $suggestedPrice;

    }

    return $cart_item_data;
}

add_action( 'woocommerce_checkout_create_order_line_item', function ( $item, $cart_item_key, $values ) {
    if ( isset( $values['suggested-price'] ) ) {
        $item->update_meta_data( 'suggested-price', $values['suggested-price'] );
    }
}, 20, 3 );