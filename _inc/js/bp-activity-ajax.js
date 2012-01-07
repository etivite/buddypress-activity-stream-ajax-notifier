jQuery(document).ready( function() {
	
	if ( jQuery("input#_wpnonce_activity_filter") && jQuery("input#date_recorded") ) {
	
		var gid = '';
		var uid = '';
		var ca = '';
	
		setInterval(function() {
			
			if ( jQuery("input#gid").val() )
				gid = jQuery("input#gid").val();
				
			if ( jQuery("input#uid").val() )
				uid = jQuery("input#uid").val();
			
			if ( jQuery("input#ca").val() )
				ca = jQuery("input#ca").val();
			
			jQuery.post( ajaxurl, {
				action: 'bpactivity_ajax',
				timeout: 1500,
				cache: false,
				'_wpnonce' : jQuery("input#_wpnonce_activity_filter").val(),
				'cookie': encodeURIComponent(document.cookie),
				'gid' : gid,
				'uid' : uid,
				'ca' : ca,
				'checkdate' : jQuery("input#date_recorded").val(),
				'checkobject': 'activity',
			},
			function( data ) {
				
				if ( data && parseInt( data ) > 0 ) {
				
					if (jQuery('#activity-stream li').first().attr( 'id' ) == 'activity-' + data ) {
					} else {
						jQuery('#activity-notifier').attr("href", window.location.href);
						jQuery('#activity-notifier').slideDown();
					}
					
				}

			});
			
			return false;
		}, BPAA.streamajaxtimeout ); // timeout polling
	
	}

});
