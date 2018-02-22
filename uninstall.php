<?php 
/*
 * Removes options from database when plugin is deleted.
 *  
 *
 */

//if uninstall not called from WordPress exit
if (!defined('WP_UNINSTALL_PLUGIN' ))
    exit();


delete_option('cm_order_smstext_pending');
delete_option('cm_order_smstext_processing');
delete_option('cm_order_smstext_completed');
delete_option('cm_order_notification_pending');
delete_option('cm_order_notification_processing');
delete_option('cm_order_notification_completed');

delete_option('cm_user_notification');
delete_option('cm_registration_smstext');
delete_option('cm_sid');
delete_option('cm_user');
delete_option('cm_pass');

?>