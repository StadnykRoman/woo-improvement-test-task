<?php

defined( 'ABSPATH' ) || exit;

add_action( 'add_meta_boxes_product', 'meta_box_for_product' );
function meta_box_for_product( $post ){
  add_meta_box( 'information-for-goners', 'Information for goners', 'wpc_add_inf_goners_meta_box', 'product', 'normal', 'low');
  add_meta_box( 'separate-order', 'Separate order', 'wpc_add_separate_order_meta_box', 'product', 'normal', 'low');
}

function wpc_add_inf_goners_meta_box( $post ){
        wp_nonce_field( basename( __FILE__ ), 'product_meta_box_nonce' );
        $information_for_goners = get_post_meta( $post->ID, '_information_for_goners', true); 
    ?>
        <div class='form-row'>
            <input type="text" name="_information_for_goners" value="<?php echo $information_for_goners; ?>" /> 
        </div>
    <?php 
}

function wpc_add_separate_order_meta_box( $post ){
  wp_nonce_field( basename( __FILE__ ), 'product_meta_box_nonce' );
  $separate_order = get_post_meta( $post->ID, '_separate_order', true); 
?>
  <div class='form-row'>
    <select name="_separate_order" id="separate_order" class="select short">
      <option value="no" <?php echo $separate_order == 'no' ? 'selected="selected"' : ''; ?>>No</option>
      <option value="yes" <?php echo $separate_order == 'yes' ? 'selected="selected"' : ''; ?>>Yes</option>
    </select>
  </div>
<?php 
}

add_action( 'save_post_product', 'wpc_save_meta_box_data', 10, 2 );
function wpc_save_meta_box_data( $post_id ){
  if ( !isset( $_POST['product_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['product_meta_box_nonce'], basename( __FILE__ ) ) ){
    return;
  }

  if ( isset( $_POST['_information_for_goners'] ) ) {
    update_post_meta( $post_id, '_information_for_goners', sanitize_text_field( $_POST['_information_for_goners'] ) );
  }

  if ( isset( $_POST['_separate_order'] ) ) {
    update_post_meta( $post_id, '_separate_order', sanitize_text_field( $_POST['_separate_order'] ) );
  }
}