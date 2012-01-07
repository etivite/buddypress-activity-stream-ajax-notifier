<?php 

function etivite_bp_activity_ajax_admin() {
	global $bp;

	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if ( isset( $_POST['submit'] ) && check_admin_referer('etivite_bp_activity_ajax_admin') ) {
	
		$new = array();
	
		if( isset( $_POST['ab_activity_ajax_time'] ) && !empty( $_POST['ab_activity_ajax_time'] ) && $_POST['ab_activity_ajax_time'] > 5000 ) {
			$new['ajaxtimeout'] = $_POST['ab_activity_ajax_time'];
		} else {
			$new['ajaxtimeout'] = 60000;
		}
		
		update_option( 'etivite_bp_activity_ajax', $new );
		
		$updated = true;
	}
	
	// Get the proper URL for submitting the settings form. (Settings API workaround) - boone
	$url_base = function_exists( 'is_network_admin' ) && is_network_admin() ? network_admin_url( 'admin.php?page=bp-activity-ajax-settings' ) : admin_url( 'admin.php?page=bp-activity-ajax-settings' );
	
	$data = get_option( 'etivite_bp_activity_ajax', array( 'ajaxtimeout' => 60000 ) );
	
?>	
	<div class="wrap">
		<h2><?php _e( 'Activity Ajax Notifier Admin', 'bp-activity-ajax' ); ?></h2>

		<?php if ( isset($updated) ) : echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-activity-ajax' ) . "</p></div>"; endif; ?>

		<form action="<?php echo $url_base; ?>" name="bp-activity-ajax-settings-form" id="bp-activity-ajax-settings-form" method="post">

			<h5><?php _e( 'Ajax Polling Timeout', 'bp-activity-ajax' ); ?></h5>
	
			<table class="form-table">
				<th><label for="ab_activity_ajax_time"><?php _e( "Time length (milliseconds):", 'bp-activity-ajax' ) ?></label> </th>
				<td><input type="text" name="ab_activity_ajax_time" id="ab_activity_ajax_time" value="<?php echo $data['ajaxtimeout']; ?>"/></td>
			</table>
			
			<p class="description">Default polling time between new activity checks is 1 second (60000 milliseconds) min: 5000 ms</p>
			
			<?php wp_nonce_field( 'etivite_bp_activity_ajax_admin' ); ?>
			
			<p class="submit"><input type="submit" name="submit" value="<?php _e('Save Settings','bp-activity-ajax') ?>"/></p>
			
		</form>
		
		<h3>About:</h3>
		<div id="plugin-about" style="margin-left:15px;">
			
			<p>
			<a href="http://etivite.com/wordpress-plugins/buddypress-activity-stream-ajax-notifier/">BuddyPress Activity Stream Ajax Notifier - About Page</a><br/> 
			</p>
		
			<div class="plugin-author">
				<strong>Author:</strong> <a href="http://profiles.wordpress.org/users/etivite/"><img style="height: 24px; width: 24px;" class="photo avatar avatar-24" src="http://www.gravatar.com/avatar/9411db5fee0d772ddb8c5d16a92e44e0?s=24&amp;d=monsterid&amp;r=g" alt=""> rich @etivite</a><br/>
				<a href="http://twitter.com/etivite">@etivite</a> <a href="https://plus.google.com/114440793706284941584">+etivite</a>
			</div>
		
			<p>
			<a href="http://etivite.com">Author's site</a><br/>
			<a href="http://etivite.com/api-hooks/">Developer Hook and Filter API Reference</a><br/>
			<a href="http://etivite.com/wordpress-plugins/">WordPress Plugins</a><br/>
			</p>
		</div>
		
	</div>
<?php
}

?>
