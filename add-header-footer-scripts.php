<?php
/**
 * Plugin Name: Add Header Footer Scripts
 * Plugin URI: https://github.com/np2861996/Add-Header-Footer-Scripts-Plugin
 * Description: Quick, easy, advance plugin for Add Header Footer Scripts. 
 * Author: BeyondN
 * Author URI: https://beyondn.net/
 * Text Domain: Header_Footer_Scripts
 * Version: 1.0.0
 *
 * @package Header_Footer_Scripts
 * @author BeyondN
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define("AHFS", '1.0.0');

function ahfs_registerSettings() {
	$plugin_data = get_plugin_data( __FILE__ );
	$plugin_name = $plugin_data['Name'];
	register_setting( $plugin_name, 'insert_header_script_gk', 'trim' );
	register_setting( $plugin_name, 'insert_body_script_gk', 'trim' );
	register_setting( $plugin_name, 'insert_footer_script_gk', 'trim' );
}
add_action( 'admin_init', 'ahfs_registerSettings' );

function ahfs_enqueue_styles_scripts_header_footer_script()
{

    if( is_admin() ) {
        $css= plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/css/style.css";
        wp_enqueue_style( 'main-header-footer-script-css', $css, array(), AHFS );
    }
}
add_action( 'admin_enqueue_scripts', 'ahfs_enqueue_styles_scripts_header_footer_script' );

function ahfs_output($setting){
	
	if ( apply_filters( 'disable_insert', false ) ) {
		return;
	}
	
	if('insert_header_script_gk'==$setting && apply_filters( 'disable_insert_header', false )){
		return;
	}
	
	if('insert_body_script_gk'==$setting && apply_filters( 'disable_insert_body', false )){
		return;
	}

	if('insert_footer_script_gk'==$setting && apply_filters( 'disable_insert_footer', false )){
		return;
	}
	$meta = get_option( $setting );
	if ( empty( $meta ) ) {
		return;
	}
	if ( trim( $meta ) == '' ) {
		return;
	}

	// Output
	
	_e(html_entity_decode(wp_unslash($meta)));
}

function ahfs_frontendHeaderScript(){
	ahfs_output('insert_header_script_gk');
}
add_action('wp_head', 'ahfs_frontendHeaderScript',100);

function ahfs_frontendFooterScript(){	
	ahfs_output('insert_footer_script_gk');	
}
add_action('wp_footer', 'ahfs_frontendFooterScript',100);


function ahfs_frontendBodyScript() {	
	ahfs_output('insert_body_script_gk');
}
add_action('wp_body_open', 'ahfs_frontendBodyScript',100);

register_activation_hook( __FILE__, 'ahfs_plugin_activation' );

function ahfs_plugin_activation(){
	if (is_plugin_active( 'insert-header-footer-scripts-pro/insert-header-footer-scripts-pro.php' ) ) {
		deactivate_plugins('insert-header-footer-scripts-pro/insert-header-footer-scripts-pro.php');
	}
}

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'ahfs_plugin_add_settings_link');

function ahfs_plugin_add_settings_link( $links ) { 
	$support_link = '<a href="https://beyondn.net/"  target="_blank" >' . __( 'Support','Header_Footer_Scripts' ) . '</a>'; 
	array_unshift( $links, $support_link );	

	$pro_link = '<a href="https://beyondn.net/"  target="_blank" style="color:#46b450;font-weight: 600;">' . __( 'Premium Upgrade', 'Header_Footer_Scripts' ) . '</a>'; 
	array_unshift( $links, $pro_link );

	$settings_link = '<a href="/wp-admin/admin.php?page=ahfs-admin-page">' . __( 'Settings','Header_Footer_Scripts' ) . '</a>'; 	
	array_unshift( $links, $settings_link );

	return $links;
}


add_action('wp_footer', 'ahfs_frontendFooterScript',100);
function my_admin_menu() {
    add_menu_page(
        __( 'Add Header Footer Scripts', 'Header_Footer_Scripts' ),
        __( 'Add Header Footer Scripts', 'Header_Footer_Scripts' ),
        'manage_options',
        'ahfs-admin-page',
        'ahfs_admin_page_contents',
        'dashicons-schedule',
        3
    );
}
add_action( 'admin_menu', 'my_admin_menu' );

/* Added ahfs admin page function  */ 
function ahfs_admin_page_contents() {
    include( plugin_dir_path( __FILE__ ) . 'ahfs-admin-page.php' );
}

function ahfs_admin_page_settings_init() {
	add_settings_section(
		'ahfs_admin_page_setting_section',
		__( 'Header Footer Scripts settings', 'Header_Footer_Scripts' ),
		'ahfs_admin_page_setting_section_callback_function',
		'ahfs-admin-page'
	);

	add_settings_field(
		'ahfs_admin_page_setting_field',
		__( 'Header Footer Scripts setting field', 'Header_Footer_Scripts' ),
		'ahfs_admin_page_setting_markup',
		'ahfs-admin-page',
		'ahfs_admin_page_setting_section'
	);

	register_setting( 'ahfs-admin-page', 'ahfs_admin_page_setting_field' );
}
add_action( 'admin_init', 'ahfs_admin_page_settings_init' );

function ahfs_admin_page_setting_section_callback_function( $args ){

	echo '<p>Intro text for our settings section</p>';

}

function ahfs_admin_page_setting_markup() {
    ?>
    <label for="my_setting_field"><?php _e( 'My Input', 'Header_Footer_Scripts' ); ?></label>
    <input type="text" id="ahfs_admin_setting_field" name="ahfs_admin_setting_field">
    <?php
}