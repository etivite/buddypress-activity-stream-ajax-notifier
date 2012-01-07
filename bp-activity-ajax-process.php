<?php
function etivite_bp_activity_ajax_process_ajax() {
	if ( $_POST['checkobject'] == 'activity' )
		etivite_bp_activity_ajax_process_ajax_check_newactivity();

	die();
}
add_action( 'wp_ajax_bpactivity_ajax', 'etivite_bp_activity_ajax_process_ajax' );

function etivite_bp_activity_ajax_process_ajax_check_newactivity() {
	global $bp;

	if ( !is_user_logged_in() )
		die();

	check_ajax_referer("activity_filter");

	$object = $_POST['checkobject'];
	$_BP_COOKIE = &$_COOKIE;
	$qs = false;


	//hijack the system
	if ( isset($_POST['gid'] ) && !empty($_POST['gid']) ) {
		$bp->groups->current_group = new BP_Groups_Group( (int)$_POST['gid'] );
		$object = 'groups';
	}
	if ( isset($_POST['uid'] ) && !empty($_POST['uid']) ) {
		$bp->displayed_user->id = (int)$_POST['uid'];
		$bp->displayed_user->userdata = bp_core_get_core_userdata( $bp->displayed_user->id );
	}	
	if ( isset($_POST['ca'] ) && !empty($_POST['ca']) )
		$bp->current_action = $_POST['ca'];


	/* If page and search_terms have been passed via the AJAX post request, use those */
	if ( !empty( $_BP_COOKIE['bp-' . $object . '-page'] ) )
		die();

	if ( !empty( $_BP_COOKIE['bp-' . $object . '-filter'] ) && '-1' != $_BP_COOKIE['bp-' . $object . '-filter'] ) {
		$qs[] = 'type=' . $_BP_COOKIE['bp-' . $object . '-filter'];
		$qs[] = 'action=' . $_BP_COOKIE['bp-' . $object . '-filter']; // Activity stream filtering on action
	}

	if ( !empty( $_BP_COOKIE['bp-' . $object . '-scope'] ) ) {
		if ( 'personal' == $_BP_COOKIE['bp-' . $object . '-scope'] ) {
			$user_id = ( $bp->displayed_user->id ) ? $bp->displayed_user->id : $bp->loggedin_user->id;
			$qs[] = 'user_id=' . $user_id;
			$qs[] = 'scope=just-me';
		}
		if ( 'personal' != $_BP_COOKIE['bp-' . $object . '-scope'] && 'all' != $_BP_COOKIE['bp-' . $object . '-scope'] && empty( $bp->displayed_user->id ) )
			$qs[] = 'scope=' . $_BP_COOKIE['bp-' . $object . '-scope']; // Activity stream scope only on activity directory.
	}

	if ( !empty( $_BP_COOKIE['bp-' . $object . '-search-terms'] ) )
		$qs[] = 'search_terms=' . $_BP_COOKIE['bp-' . $object . '-search-terms'];
		
	$qs[] = 'max=1';
	//$qs[] = 'object='. $object;

	/* Now pass the querystring to override default values. */
	$query_string = empty( $qs ) ? '' : join( '&', (array)$qs );

	//pass it into a query - grab date_created stuff and compare to posted date
	if ( bp_has_activities( $query_string ) ) {
	
		if ( etivite_bp_activity_ajax_check_activity_date_recorded( $_POST['checkdate'] ) ) {
			echo etivite_bp_activity_ajax_get_activity_id();
		} else {
			echo '-1';
		}
	} else {
		echo '-1';
	}
	
}

function etivite_bp_activity_ajax_get_activity_id() {
	global $activities_template;

	if ( !$activities_template->activities )
		return 0;
	
	return $activities_template->activities[0]->id;
}

function etivite_bp_activity_ajax_get_activity_date_recorded() {
	global $activities_template;
	
	if ( !$activities_template->activities )
		return 0;
	
	return $activities_template->activities[0]->date_recorded;
}

function etivite_bp_activity_ajax_check_activity_date_recorded( $ajax_date_recorded ) {
	global $activities_template;

	if ( !$ajax_date_recorded )
		return false;
	
	if ( !$activities_template->activities )
		return false;
	
	if ( strtotime( $activities_template->activities[0]->date_recorded ) > $ajax_date_recorded )
		return true;
		
	return false;
}
?>
