<?php
/**
 * Plugin Name: WooImprovement
 * Description: Improvement for woocommerce
 * Version: 1.0.0
 * Author: Roman Stadnyk
 */

defined( 'ABSPATH' ) || exit;


require dirname( __FILE__ ) . '/includes/admin/product.php';
require dirname( __FILE__ ) . '/includes/frontend/product.php';
require dirname( __FILE__ ) . '/includes/frontend/checkout-order.php';