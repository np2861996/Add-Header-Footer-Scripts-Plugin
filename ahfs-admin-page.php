<?php 
if( !defined( 'ABSPATH' ) ) exit;
if(current_user_can('manage_options') && isset($_POST['submit_option'])){
	$header_script = htmlspecialchars($_POST['header_script']);
	$body_script = htmlspecialchars($_POST['body_script']);
	$footer_script = htmlspecialchars($_POST['footer_script']);
	$nonce=sanitize_text_field($_POST['insert_script_wpnonce']);

	if(wp_verify_nonce( $nonce, 'insert_script_option_nonce' ))
	{
		update_option('insert_header_script_gk',$header_script);
		update_option('insert_body_script_gk',$body_script);
		update_option('insert_footer_script_gk',$footer_script);
		$successmsg= ahfs_success_option_msg('Settings Saved.');
	}
	else
	{
        $errormsg= ahfs_failure_option_msg('Unable to save data!');
    }
}
function ahfs_failure_option_msg($msg)
{
	_e('<div class="notice notice-error ahfs-error-msg is-dismissible"><p>' . $msg . '</p></div>','insert-script-in-headers-and-footers');	
}
function ahfs_success_option_msg($msg)
{
	_e('<div class="notice notice-success ahfs-success-msg is-dismissible"><p>'. $msg . '</p></div>','insert-script-in-headers-and-footers');
}
function ahfs_get_option_header_script()
{
	return wp_unslash(get_option('insert_header_script_gk'));
}
function ahfs_get_option_body_script()
{
	return wp_unslash(get_option('insert_body_script_gk'));
}
function ahfs_get_option_footer_script()
{
	return wp_unslash(get_option('insert_footer_script_gk'));
}
$header_script= ahfs_get_option_header_script();
$body_script= ahfs_get_option_body_script();
$footer_script= ahfs_get_option_footer_script();

?>
   <div class="wrap ahfs-script-wrap">

<h2><?php _e('Add Headers And Footers Script &raquo; Settings','Header_Footer_Scripts'); ?></h2>

<?php
if ( isset( $successmsg ) ) {
	?>
	<div class="ahfs_updated fade"><p><?php _e($successmsg,'Header_Footer_Scripts'); ?></p></div>
	<?php
}
if ( isset( $errormsg ) ) {
	?>
	<div class="error fade"><p><?php _e($errormsg,'Header_Footer_Scripts'); ?></p></div>
	<?php
}
$nonce= wp_create_nonce('insert_script_option_nonce');
?>
<div class="row">
	<div class='col-6'>
	<div class="ahfs-inner">
		<h4 class="heading-h4"><?php _e('Settings','Header_Footer_Scripts'); ?></h4>
		
		<form method="post">
			<p>
				<label for="script_in_header"> <?php _e('Scripts in Header','Header_Footer_Scripts'); ?> </label>
				<textarea name="header_script" rows="8" class="ahfs-header-footer-textarea" ><?php _e($header_script); ?></textarea>
				<?php _e('These scripts will be printed in the <code>&lt;head&gt;</code> section.','Header_Footer_Scripts'); ?>
			</p>
			<p>
				<label for="script_in_body"> <?php _e('Scripts in Body','Header_Footer_Scripts'); ?> </label>
				<textarea name="body_script" rows="8" class="ahfs-header-footer-textarea" ><?php _e($body_script); ?></textarea>
				<?php _e('These scripts will be printed below the <code>&lt;body&gt;</code> section.','Header_Footer_Scripts'); ?>
			</p>
			<p>
				<label for="script_in_footer"> <?php _e('Scripts in Footer','Header_Footer_Scripts'); ?> </label>
				<textarea name="footer_script" rows="8" class="ahfs-header-footer-textarea" ><?php _e($footer_script); ?></textarea>
				<?php _e('These scripts will be printed above the <code>&lt;body&gt;</code> section.','Header_Footer_Scripts'); ?>
			</p>

			<?php
			
			$ahfs_pages = '';
			$args = array(
				'sort_order' => 'asc',
				'sort_column' => 'post_title',
				'hierarchical' => 1,
				'exclude' => '',
				'include' => '',
				'meta_key' => '',
				'meta_value' => '',
				'authors' => '',
				'child_of' => 0,
				'parent' => -1,
				'exclude_tree' => '',
				'number' => '',
				'offset' => 0,
				'post_type' => 'page',
				'post_status' => 'publish'
				); 
				$pages = get_pages($args); // get all pages based on supplied args

				foreach($pages as $page){ // $pages is array of object
				
					$ahfs_pages .= '<option value="'.$page->ID.'">'.get_the_title( $page->ID ).'</option>';
				}

				echo $dis_ahfs_pages = '<select name="cars" id="cars" multiple>'.$ahfs_pages.'</select>';

			?>

			<input type="hidden" name="insert_script_wpnonce" value="<?php esc_attr_e($nonce); ?>">
			<input type="submit" class="button button-primary " name="submit_option" value="Save">
			
		</form>
		</div>
		
	</div>
	<div class="col-6">
		<div class="ahfs_pro_details">
			<h2><?php esc_html_e('Insert Script In Headers And Footers Pro','Header_Footer_Scripts'); ?></h2>
			<ul>
				<li><?php esc_html_e('Add script to single page priority of loading script.','Header_Footer_Scripts'); ?></li>
				<li><?php esc_html_e('Add header script to single post, custom post and page.','Header_Footer_Scripts'); ?></li>
				<li><?php esc_html_e('Add Footer script to single post, custom Post and page.','Header_Footer_Scripts'); ?></li>
				<li><?php esc_html_e('Give Priority to Script(At Beginning or At End)','Header_Footer_Scripts'); ?></li>
				<li><?php esc_html_e('Select where to Show Script - Admin or Front Side','Header_Footer_Scripts'); ?></li>
				<li><?php esc_html_e('Add Script to Post, Custom Post and Page','Header_Footer_Scripts'); ?></li>
				<li><?php esc_html_e('Controlling the priority of loading script code.','Header_Footer_Scripts'); ?></li>
				<li>
				<?php esc_html_e('Basic code editor options','Header_Footer_Scripts'); ?>
					<ul>
						<li><?php esc_html_e('Code syntax highlighting','Header_Footer_Scripts'); ?></li>
						<li><?php esc_html_e('Line numbering','Header_Footer_Scripts'); ?></li>
						<li><?php esc_html_e('Active line highlighting','Header_Footer_Scripts'); ?></li>
						<li><?php esc_html_e('Tab indentation','Header_Footer_Scripts'); ?></li>
					</ul>
				</li>
				<li><?php esc_html_e('Timely','Header_Footer_Scripts'); ?> <a href="<?php echo esc_url('https://beyondn.net/'); ?>" target="_blank"><?php esc_html_e('support','Header_Footer_Scripts'); ?></a> <?php esc_html_e('24/7.','Header_Footer_Scripts'); ?></li>
				<li><?php esc_html_e('Regular updates.','Header_Footer_Scripts'); ?></li>
				<li><?php esc_html_e('Well documented.','Header_Footer_Scripts'); ?></li>
			</ul>
			<a href="<?php echo esc_url('https://beyondn.net/'); ?>" title="<?php echo esc_attr('Upgrade to Premium','Header_Footer_Scripts'); ?>" class="ahfs_premium_btn" target="_blank"><?php esc_html_e('Upgrade to Premium','Header_Footer_Scripts'); ?></a>
		</div>
	</div>
</div>


</div>