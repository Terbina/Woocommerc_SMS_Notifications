<?php
/*
Plugin Name: WP SMS Alert
Plugin URI: 
Description: Sends SMS notification on customer registration and woocommerce order.
Version: 1.3.1
Author: C.M.Sayedur Rahman
Author URI: www.sslwireless.com
*/
/*

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// to set default config on activation
register_activation_hook(__FILE__,'status_notifier_defaults');

add_action('admin_menu','ssl_sms_plugin_top_menu');
function ssl_sms_plugin_top_menu(){
   add_menu_page('SMS Notification', 'SMS Notification', 'manage_options', __FILE__, 'sn_options_page', plugins_url('/wp-sms-notifications/img/ssllogo.jpg',__DIR__));
 }


function status_notifier_defaults() {
    add_option('cm_order_smstext_pending',"Dear Customer, your order is not completed, Your due amount is {{amt}} and order id is {{oid}} ");
    add_option('cm_order_smstext_processing',"Dear Customer, your order is in processing, Your paid amount is {{amt}} and order id is {{oid}} ");
    add_option('cm_order_smstext_completed',"Dear Customer, your order is successfully completed, Your paid amount is {{amt}} and order id is {{oid}} ");
    add_option('cm_order_notification_pending','yes');
    add_option('cm_order_notification_processing','yes');
    add_option('cm_order_notification_completed','yes');

    add_option('cm_user_notification','yes');
    add_option('cm_registration_smstext',"Dear Customer, your registration to this site has been successfully completed");
    add_option('cm_sid','');
    add_option('cm_user','');
    add_option('cm_pass','');

}

function sn_options_page() {
	if(isset($_POST['save'])) {
        update_option('cm_order_smstext_pending',$_POST['cm_order_smstext_pending']);
        update_option('cm_order_smstext_processing',$_POST['cm_order_smstext_processing']);
        update_option('cm_order_smstext_completed',$_POST['cm_order_smstext_completed']);
        update_option('cm_order_notification_pending',$_POST['cm_order_notification_pending']);
        update_option('cm_order_notification_processing',$_POST['cm_order_notification_processing']);
        update_option('cm_order_notification_completed',$_POST['cm_order_notification_completed']);

        update_option('cm_user_notification',$_POST['cm_user_notification']);
        update_option('cm_registration_smstext',$_POST['cm_registration_smstext']);
        update_option('cm_sid',$_POST['cm_sid']);
        update_option('cm_user',$_POST['cm_user']);
        update_option('cm_pass',$_POST['cm_pass']);
	  echo "<div id='message' class='updated fade'><p>Notification settings saved.</p></div>";
    }
    ?>
	<div class="wrap"><h2>SMS Notifications</h2>
	<form name="site" action="" method="post" id="notifier">

	<div id="review">
	
	<br />

	<fieldset id="reviewdiv">
	<legend><b style="font-size: 20px"><?php _e('SMS Notification Authentication Credentials') ?></b></legend>
	<div>
        <label for="user" style="vertical-align: top">User</label><br /><input type="text" tabindex="2" id="cm_user" name="cm_user" <?php if(get_option('cm_user')!=''){?> value="<?php echo get_option('cm_user');?>" <?php }?>/><br /><br />
        <label for="pass" style="vertical-align: top">Password</label><br /><input type="text" tabindex="2" id="cm_pass" name="cm_pass" <?php if(get_option('cm_pass')!=''){?> value="<?php echo get_option('cm_pass');?>" <?php }?>/><br /><br />
        <label for="sid" style="vertical-align: top">SID</label><br /><input type="text" tabindex="2" id="cm_sid" name="cm_sid" <?php if(get_option('cm_sid')!=''){?> value="<?php echo get_option('cm_sid');?>" <?php }?>/><br /><br />
    </div>
        <legend><b style="font-size: 20px"><?php _e('SMS Notification Setting') ?></b></legend>
    <div>
        <label for="cm_user_notification" class="selectit"><input type="checkbox" tabindex="2" id="cm_user_notification" name="cm_user_notification" value="yes" <?php if(get_option('cm_user_notification')=='yes') echo 'checked="checked"'; ?> /> Notify on New User Registration</label><br />
    <label for="cm_registration_smstext" style="vertical-align: top">SMS Text on Registration</label><br /><textarea  wrap="off"  rows="2" cols="160" tabindex="2" id="cm_registration_smstext" name="cm_registration_smstext"><?php if(get_option('cm_registration_smstext')!='')echo get_option('cm_registration_smstext');?></textarea><br /><br />

        <label for="cm_order_notification_pending" class="selectit">
            <input type="checkbox" tabindex="3" id="cm_order_notification_pending" name="cm_order_notification_pending" value="yes" <?php if(get_option('cm_order_notification_pending')=='yes') echo 'checked="checked"'; ?> /> Notify on Order Status Pending</label>
    <br />
    <label for="cm_order_smstext_pending" style="vertical-align: top">SMS Text on Order Pending</label><br /><textarea  wrap="off"  rows="2" cols="160" tabindex="2" id="cm_order_smstext_pending" name="cm_order_smstext_pending"><?php if(get_option('cm_order_smstext_pending')!='')echo get_option('cm_order_smstext_pending');?></textarea>
	<br />
    <label for="cm_order_notification_processing" class="selectit"><input type="checkbox" tabindex="3" id="cm_order_notification_processing" name="cm_order_notification_processing" value="yes" <?php if(get_option('cm_order_notification_processing')=='yes') echo 'checked="checked"'; ?> /> Notify on Order Status Processing</label>
    <br />
    <label for="cm_order_smstext_processing" style="vertical-align: top">SMS Text on Order Processing</label><br /><textarea  wrap="off"  rows="2" cols="160" tabindex="2" id="cm_order_smstext_processing" name="cm_order_smstext_processing"><?php if(get_option('cm_order_smstext_processing')!='')echo get_option('cm_order_smstext_processing');?></textarea>
        <br />
        <label for="cm_order_notification_completed" class="selectit"><input type="checkbox" tabindex="3" id="cm_order_notification_completed" name="cm_order_notification_completed" value="yes" <?php if(get_option('cm_order_notification_completed')=='yes') echo 'checked="checked"'; ?> /> Notify on Order Status Completed</label>
        <br />
        <label for="cm_order_smstext_completed" style="vertical-align: top">SMS Text on Order Completed</label><br /><textarea  wrap="off"  rows="2" cols="160" tabindex="2" id="cm_order_smstext_completed" name="cm_order_smstext_completed"><?php if(get_option('cm_order_smstext_completed')!='')echo get_option('cm_order_smstext_completed');?></textarea>

    </fieldset>
	<br /><strong style="color: red"> Note: Please check the delivered sms text by doing a new Registration and Placing an order.</strong>
	<p class="submit">
	<input name="save" type="submit" id="savenotifier" tabindex="6" style="font-weight: bold;" value="Save Settings" />
	</p>
	</div>
	
	</form>
	<small>Powered by SSL Wireless</small>
	</div>
	<?php
}

// Hook for post status changes
//add_action( 'woocommerce_order_status_changed', 'order_status_changed', 10, 1 );
//add_action( 'woocommerce_order_status_completed', 'woocommerce_order_status_completed', 10, 2 ); 
add_action('woocommerce_order_status_pending','order_pending_action');
add_action('woocommerce_order_status_processing','order_processing_action');
add_action('woocommerce_order_status_completed','order_completed_action');

function order_pending_action($order_id)
{
    $order = new WC_Order( $order_id );
    $order_amount=$order->get_total();
    $user_id = $order->user_id;
    $user    = get_userdata( $user_id );
    $customer_mobile=$user->billing_phone;
    $smstext= get_option('cm_order_smstext_pending');
    $smstext_alert= get_option('cm_order_notification_pending');
    if( (strtolower($smstext_alert) == "yes")&& !empty($customer_mobile) && !empty($smstext))
    {
        $smstext=str_ireplace("{{oid}}",$order_id,$smstext);
        $smstext=str_ireplace("{{amt}}",$order_amount,$smstext);
        send_sms($smstext,$customer_mobile);
    }

}



function order_processing_action($order_id)
{
    $order = new WC_Order( $order_id );
    $order_amount=$order->get_total();
    $user_id = $order->user_id;
    $user    = get_userdata( $user_id );
    $customer_mobile=$user->billing_phone;
    $smstext= get_option('cm_order_smstext_processing');
    $smstext_alert= get_option('cm_order_notification_processing');
    if( (strtolower($smstext_alert) == "yes")&& !empty($customer_mobile) && !empty($smstext))
    {
        $smstext=str_ireplace("{{oid}}",$order_id,$smstext);
        $smstext=str_ireplace("{{amt}}",$order_amount,$smstext);
        send_sms($smstext,$customer_mobile);
    }

}


function order_completed_action($order_id)
{
    $order = new WC_Order( $order_id );
    $order_amount=$order->get_total();
    $user_id = $order->user_id;
    $user    = get_userdata( $user_id );
    $customer_mobile=$user->billing_phone;
    $smstext= get_option('cm_order_smstext_completed');
    $smstext_alert= get_option('cm_order_notification_completed');
    if( (strtolower($smstext_alert) == "yes")&& !empty($customer_mobile) && !empty($smstext))
    {
        $smstext=str_ireplace("{{oid}}",$order_id,$smstext);
        $smstext=str_ireplace("{{amt}}",$order_amount,$smstext);
        send_sms($smstext,$customer_mobile);

    }

}

function send_sms($smstext,$customer_mobile)
{

    //   $customer_mobile='8801913900620';
    $user =get_option('cm_user');
    $pass = get_option('cm_pass');
    $sid = get_option('cm_sid');
    $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
    $unique_id = uniqid();
    $param = "user=$user&pass=$pass&sid=$sid&";
    $sms = "sms[0][0]=$customer_mobile&sms[0][1]=" . urlencode($smstext) . "&sms[0][2]=$unique_id";
    $data = $param . $sms . $sid;

    $crl = curl_init();
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_HEADER, 0);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($crl, CURLOPT_POST, 1);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($crl);
    curl_close($crl);
}

function order_status_changed($order_id)
{
    $order = new WC_Order( $order_id );
    $user_id = $order->user_id;
    $user    = get_userdata( $user_id );
    $customer_mobile=$user->billing_phone;
    // echo "order status".$order->status;
    //echo "order status to sent alert".get_option('orderstatus');
    // die();
    if( (strtolower($order->status) == strtolower(get_option('orderstatus')))&& !empty($customer_mobile))
    {
        $smstext= get_option('order_smstext');
        $smstext=str_ireplace("{{oid}}",$order_id,$smstext);
        send_sms($smstext,$customer_mobile);
    }

}

add_action('user_register', 'send_registration_sms');
function send_registration_sms( $user_id )
{
    $user    = get_userdata( $user_id );
    $smstext= get_option('registration_smstext');
    //$customer_mobile='8801913900620';
    $customer_mobile=$user->billing_phone;
    if(!empty($smstext) && !empty($customer_mobile))
    {
        send_sms($smstext,$customer_mobile);
    }


}
