=== Plugin Name ===
Contributors: nuprn1, etivite
Donate link: http://etivite.com/wordpress-plugins/donate/
Tags: buddypress, activity stream
Requires at least: PHP 5.2, WordPress 3.2.1 BuddyPress 1.5.1
Tested up to: PHP 5.2.x, WordPress 3.2.1, BuddyPress 1.5.1
Stable tag: 0.1.2

This plugin will display a simple twitter-like notification 'New activity update. Refresh the page.' via ajax if a new activity stream record has been posted.

== Description ==

** IMPORTANT **
This plugin has been updated for BuddyPress 1.5.1

This plugin will display a simple twitter-like notification 'New activity update. Refresh the page.' via ajax if a new activity stream record has been posted.

Polling is enabled for certain areas - main activity, group activity, profile activity (and the subnav - just-me, friends, groups, mentions)

Does not return a # of new activities - Does not live refresh the page. (no plans - future BP roadmap to include this already)

Restricted to loggedin_users, does not check for new activity comments.

The default polling is every 2 minutes (120000 milliseconds)

= Related Links: = 

* <a href="http://etivite.com" title="Plugin Demo Site">Author's Site</a>
* <a href="http://etivite.com/wordpress-plugins/buddypress-activity-stream-ajax-notifier/">BuddyPress Activity Stream Ajax Notifier - About Page</a>
* <a href="http://etivite.com/api-hooks/">BuddyPress and bbPress Developer Hook and Filter API Reference</a>
* <a href="http://twitter.com/etivite">@etivite</a> <a href="https://plus.google.com/114440793706284941584?rel=author">etivite+</a>


== Installation ==

1. Upload the full directory into your wp-content/plugins directory
2. Activate the plugin at the plugin administration page

== Frequently Asked Questions ==

= How do I adjust the ajax polling settings? =

Edit the timeout polling via the wp-admin settings page

Default is: 60000

= How do I change the CSS style of the notification message? =

Override the CSS for #activity-notifier and #activity-notifier-link

= Can you display how many new activity stream records? Can you just display the new activity stream records live? =

No - the objective of this plugin is just a simple notification. BuddyPress.org RoadMap has live activity updating planned for a future release.

= How does it work? =

Due to the complex ajax loading involved with BuddyPress and the activity stream - this plugin tries to intercept the current activity-loop request via the current_action/url or bp-activity- cookies set in BP's query_string ajax handler.

A timestamp is saved within the activity-loop of the first record (if ordered by DESC - would be the most current). This value is passed via ajax along with the current determined $query_string for bp_has_activities(). 

A new activity_template request is made and a simple comparsion of the passed in timestamp vs $activities_template->activities[0]->date_recorded - and returns a simple yes/no.

= My question isn't answered here =

Please contact me on http://etivite.com


== Changelog ==

= 0.1.2 =
* BUG: tidy up php notice due on wp-admin settings page
* BUG: fix injecting ajax js on certain activity loop pages

= 0.1.1 =

* updated for buddypress 1.5
* admin page for ajax polling
* remove update notification for current user submitting status update

= 0.1.0 =

* First [BETA] version


== Upgrade Notice ==

= 0.5.1 =
* BuddyPress 1.5.1 and higher - required.

== Extra Configuration ==

