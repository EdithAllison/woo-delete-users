<?php
  
/*
 * Plugin Name: Delete Users 
 * Plugin URI: https://agentur-allison.at
 * Description: A plugin to delete users 
 * Version: 0.1
 * Author: Edith Allison
 * Author URI: https://agentur-allison.at
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 5.1
 * Tested up to: 5.3
 * WC requires at least: 3.5
 * WC tested up to: 4.0
*/

/**
 * WC_Tools_Custom_Button class.
 * https://remicorson.com/woocommerce-add-a-custom-action-in-tools/
 */
class WC_Tools_Custom_Button {
	
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
			'delete_all_users_except_admins' => array(
				'name'		=> __( 'Delete Users', '' ),
				'button'	=> __( 'DELETE 500 USERS', '' ),
				'desc'		=> __( 'Delete up to 500 users except admins. Run multiple times to delete all. On multisites, deletes users for current blog, not network. ', '' ),
				'callback'	=> array( $this, 'delete_all_users_except_admins' ),
			),
			'delete_all_customers_without_orders' => array(
				'name'		=> __( 'Delete Customers Without Orders', '' ),
				'button'	=> __( 'DELETE USERS WITHOUT ORDERS', '' ),
				'desc'		=> __( 'Delete all customers without orders. If script times out, run again. On Multisites, deletes customers for current blog not for network.   ', '' ),
				'callback'	=> array( $this, 'delete_all_customers_without_orders' ),
			),			
			'delete_network_users_without_blog' => array(
				'name'		=> __( 'Multisite: Delete Users Without Blog', '' ),
				'button'	=> __( 'DELETE USERS WITHOUT BLOG', '' ),
				'desc'		=> __( 'Delete all users not assigned to a blog. If script times out, run again.', '' ),
				'callback'	=> array( $this, 'delete_network_users_without_blog' ),
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
	public function delete_all_users_except_admins() {
		
		$args = array(
			'role__not_in' => array('administrator') 
		);
				
        $users_to_delete = get_users( $args );
        $i = 0; 

        foreach( $users_to_delete as $user_to_delete ) {
	        
	        if ($i < 500 ) {

	            // wp_delete_user() accepts another user ID as a second parameter
	            // in case you want to reassign the content to an active user
	            wp_delete_user( $user_to_delete->ID );
	            $i++; 
            
            }

        }	

		$message = $i .  __( ' Users deleted.', '' );
		return $message; 
	}
	
	/**
	 * debug_button_action function.
	 *
	 * @access public
	 * @return void
	 */
	public function delete_all_customers_without_orders() {
		
		$args = array(
			'role__not_in' => 'administrator', 
			'role' => 'customer', 
		);
				
        $users = get_users( $args );
        $i = 0; 
        
        foreach ($users as $user ) {
	        
	        $count = wc_get_customer_order_count( $user->ID);
	        
	        if ($count == 0 ) {
		        wp_delete_user( $user->ID );	
		        $i++;         
	        }
        }
		
		$message = $i .  __( ' Customers deleted.', '' );
		return $message; 
	}
		
		
	/**
	 * debug_button_action function.
	 *
	 * @access public
	 * @return void
	 */
	public function delete_network_users_without_blog() {
		
		global $wpdb; 
		
		if (is_multisite() ) {
					
	        $user_ids = $wpdb->get_col( 'SELECT ID FROM ' . $wpdb->prefix . 'users ORDER BY ID ASC'  );
	        $i = 0; 
	        
	        foreach ($user_ids as $id ) {
		        
		 		$blogs = get_blogs_of_user( $id, true );
		 		error_log( print_r($blogs, true) );
		 		
				if ( (empty( $blogs )) && (!is_super_admin($id))  ) {
		       
			        wpmu_delete_user( $id );	
			        $i++; 

				}	                
	
	        }
			
			$message = $i .  __( ' Customers deleted.', '' );
			return $message; 
		
		} else {
			
			$message =  __( 'Tool could not run. Not Multisite. ', '' );
			return $message; 			
			
		}
	}		
			
}



$GLOBALS['WC_Tools_Custom_Button'] = new WC_Tools_Custom_Button();

