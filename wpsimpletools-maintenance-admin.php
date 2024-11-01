<?php

function wpst_m_register_settings() {

    register_setting('wpsimpletools-manteinance', 'enabled');
    register_setting('wpsimpletools-manteinance', 'maintenancePage');
    register_setting('wpsimpletools-manteinance', 'url');
    register_setting('wpsimpletools-manteinance', 'pageTitle');
    register_setting('wpsimpletools-manteinance', 'pageText');
}

function wpst_m_admin_notice() {

    $enabled = esc_attr(get_option('enabled'));
    if ($enabled) {
        $class = 'notice notice-error';
        $message = __('Maintenance mode is active!', 'wpsimpletools-maintenance-mode');
        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    }
}

function wpst_m_options_page_body() {

    $enabled = esc_attr(get_option('enabled'));
    $redirect_url = esc_attr(get_option('url'));
    $maintenancePage = esc_attr(get_option('maintenancePage'));
    
    $pageTitle = esc_attr(get_option('pageTitle'));
    $pageText = esc_attr(get_option('pageText'));
    
    if (! isset($pageTitle) || trim($pageTitle) === '')
        $pageTitle = __('We\'ll be back soon!', 'wpsimpletools-maintenance-mode');
    
    if (! isset($pageText) || trim($pageText) === '')
        $pageText = __('Sorry for the inconvenience but we\'re performing some maintenance at the moment. We\'ll be back online shortly!', 'wpsimpletools-maintenance-mode');
    
    ?>


<script type="text/javascript">

jQuery(function($) {

	$('select#enabled').on('change', function() {
		manageForm()
	});

	$('select#maintenancePage').on('change', function() {
		manageForm()
	});
	
    function manageForm(){

    	var enabled = $('select#enabled').val();
    	var maintenancePage = $('select#maintenancePage').val();
    
    	if(enabled > 0){
    		$('select#maintenancePage').prop('disabled', false);
    		if(maintenancePage == 'CUSTOM'){
	    		$('input#url').prop('disabled', false);
	    		$('input#pageTitle').prop('disabled', true);
	    		$('input#pageText').prop('disabled', true);
    		}else{
    			$('input#url').prop('disabled', true);
        		$('input#pageTitle').prop('disabled', false);
        		$('input#pageText').prop('disabled', false);
    		}
    	}else{
    		$('select#maintenancePage').prop('disabled', true);
    		$('input#url').prop('disabled', true);
    		$('input#pageTitle').prop('disabled', true);
    		$('input#pageText').prop('disabled', true);
    	}
    
    }

    // onload
	manageForm();
    
});

</script>

<div class="wrap">

	<h2><?php _e('Maintenance Mode with \'coming soon\' page or redirect', 'wpsimpletools-maintenance-mode');?></h2>

	<form method="post" action="options.php">
			<?php settings_fields( 'wpsimpletools-manteinance' ); ?>
			<?php do_settings_sections( 'wpsimpletools-manteinance' ); ?>
			<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enabled', 'wpsimpletools-maintenance-mode');?></th>
				<td><select name="enabled" id="enabled">
						<option <?php if(!$enabled) { echo 'selected="selected" '; } ?> value="0"><?php _e('No', 'wpsimpletools-maintenance-mode');?></option>
						<option <?php if($enabled) { echo 'selected="selected" '; } ?> value="1" style="color: red;"><?php _e('Yes', 'wpsimpletools-maintenance-mode');?></option>
				</select></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Coming soon page', 'wpsimpletools-maintenance-mode');?></th>
				<td><select name="maintenancePage" id="maintenancePage">
						<option <?php if($maintenancePage == 'DEFAULT') { echo 'selected="selected" '; } ?> value="DEFAULT"><?php _e('Default page', 'wpsimpletools-maintenance-mode');?></option>
						<option <?php if($maintenancePage == 'CUSTOM') { echo 'selected="selected" '; } ?> value="CUSTOM"><?php _e('Custom URL', 'wpsimpletools-maintenance-mode');?></option>
				</select></td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e('URL', 'wpsimpletools-maintenance-mode');?></th>
				<td><input type="text" name="url" id="url" value="<?php echo $redirect_url; ?>" size="40" /></td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e('Coming soon page title', 'wpsimpletools-maintenance-mode');?></th>
				<td><input type="text" name="pageTitle" id="pageTitle" value="<?php echo $pageTitle; ?>" size="40" /></td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e('Coming soon page text', 'wpsimpletools-maintenance-mode');?></th>
				<td><input type="text" name="pageText" id="pageText" value="<?php echo $pageText; ?>" size="40" /></td>
			</tr>


			<tr valign="top">
				<th scope="row"><?php _e('Default page preview', 'wpsimpletools-maintenance-mode');?></th>
				<td><a target="_new" href="<?php echo esc_url( plugins_url( 'comingsoon/preview.php', __FILE__ ) ) ;  ?>">Preview</a></td>
			</tr>

		</table>
			<?php submit_button(); ?>
		</form>
</div>
<?php
}

function wpst_m_options_page() {

    if (function_exists('add_options_page'))
        add_options_page(__('Maintenance mode', 'wpsimpletools-maintenance-mode'), __('Maintenance mode', 'wpsimpletools-maintenance-mode'), 'manage_options', 'opts.php', 'wpst_m_options_page_body');
}

add_action('admin_menu', 'wpst_m_options_page');
add_action('admin_init', 'wpst_m_register_settings');
add_action('admin_notices', 'wpst_m_admin_notice');