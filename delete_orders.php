<?php
  
/*
 * Plugin Name: Delete Orders 
 * Plugin URI: https://agentur-allison.at
 * Description: A plugin to delete orders 
 * Version: 0.1
 * Author: Edith Allison
 * Author URI: https://agentur-allison.at
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 5.1
 * Tested up to: 5.4
 * WC requires at least: 3.5
 * WC tested up to: 4.0
*/

/**
 * WC_Tools_Delete_Orders_Button class.
 * https://remicorson.com/woocommerce-add-a-custom-action-in-tools/
 */
class WC_Tools_Delete_Orders_Button {
	
	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
		
		add_filter( 'woocommerce_debug_tools', array( $this,'debug_buttons' ) );

	}
	
	/**
	 * debug_button function.
	 *
	 * @access public
	 * @param mixed $old
	 * @return void
	 */
	function debug_buttons( $old ) {
		$new = array(
			'delete_all_orders' => array(
				'name'		=> __( 'Delete Orders', '' ),
				'button'	=> __( 'DELETE ORDERS', '' ),
				'desc'		=> __( 'Delete up to 500 orders. Run multiple times to delete all. On multisites, deletes orders for current blog, not network. ', '' ),
				'callback'	=> array( $this, 'delete_all_orders' ),
			),
		);
		$tools = array_merge( $old, $new );
		
		return $tools;
	}
	
	/**
	 * debug_button_action function.
	 *
	 * @access public
	 * @return void
	 */
	public function delete_all_orders() {

		$args = array(
		    'orderby' => 'date',
		    'order' => 'ASC',			
		    'return' => 'ids',
		);		
		
		// see https://github.com/woocommerce/woocommerce/wiki/wc_get_orders-and-WC_Order_Query 
		$orders = wc_get_orders( $args );
				
        $i = 0; 

        foreach( $orders as $order_id ) {
	        
	        if ($i < 500 ) {
		        
		        wp_delete_post($order_id,true);
	            $i++; 
            
            }

        }	

		$message = $i .  __( ' Orders deleted.', '' );
		return $message; 
	}
			
}


$GLOBALS['WC_Tools_Delete_Orders_Button'] = new WC_Tools_Delete_Orders_Button();
