<?php
function etivite_bp_activity_ajax_after_activity_loop() {
	global $bp;
	
	echo '<form method="post" id="activity-loop-ajax" name="activity-loop-ajax" action="">';
	echo '<input type="hidden" value="'. strtotime( etivite_bp_activity_ajax_get_activity_date_recorded() ) .'" name="date_recorded" id="date_recorded">';
	
	if ( !empty( $bp->groups->current_group ) )
		echo '<input type="hidden" value="'. $bp->groups->current_group->id .'" name="gid" id="gid">';
		
	if ( $bp->displayed_user->id )
		echo '<input type="hidden" value="'. $bp->displayed_user->id .'" name="uid" id="uid">';
	
	if ( 'just-me' == $bp->current_action || 'friends' == $bp->current_action || 'groups' == $bp->current_action || 'favorites' == $bp->current_action || 'mentions' == $bp->current_action )
		echo '<input type="hidden" value="'. $bp->current_action .'" name="ca" id="ca">';
	
	echo '</form>';
}
add_action( 'bp_after_activity_loop', 'etivite_bp_activity_ajax_after_activity_loop', 50 );

function etivite_bp_activity_ajax_notifier() {
	global $bp;
	
	if ( !is_user_logged_in() )
		return;

	echo '<div class="info" id="activity-notifier" style="display: none;"><a href="" id="activity-notifier-link" style="display:block">'. __('New activity update. Refresh the page.', 'bp-activity-ajax') .'</a></div>';
}
add_action( 'bp_before_activity_loop', 'etivite_bp_activity_ajax_notifier', 50 );

function etivite_bp_activity_ajax_head() {
	echo '<style>#activity-notifier { margin-top:10px; margin-bottom:15px; } #activity-notifier-link { background-color:#E3F1FA; border-color:#C6E4F2; border-style:solid; border-width:1px 0; color:#222222 !important; padding:0.5em 1em; text-shadow:0 1px 1px rgba(255, 255, 255, 0.5); }</style>';
}
add_action( 'bp_head', 'etivite_bp_activity_ajax_head', 50 );


function etivite_bp_activity_ajax_enqueue_scripts() {
	global $bp;

	if ( !bp_is_current_action( $bp->activity->slug ) && !bp_is_activity_front_page() && !bp_is_activity_component() && !bp_is_group_activity() && !bp_is_group_home() )
		return;

	$version = '20111013';
	$data = get_option( 'etivite_bp_activity_ajax', array( 'ajaxtimeout' => 60000 ) );

	wp_enqueue_script( 'etivite_bp_activity_ajax_notifier', WP_PLUGIN_URL .'/'. basename( dirname( __FILE__ ) ). '/_inc/js/bp-activity-ajax.js', array( 'jquery' ), $version );

	$params = array(
		'streamajaxtimeout' => $data['ajaxtimeout']
	);

	wp_localize_script( 'etivite_bp_activity_ajax_notifier', 'BPAA', $params );
}
add_action( 'wp_enqueue_scripts', 'etivite_bp_activity_ajax_enqueue_scripts' );

?>
