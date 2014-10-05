<?php 
/**
 * Plugin Name: Admin Announce
 * Plugin URI: https://github.com/tleen/wp-admin-announce
 * Description: Display a banner on the top of admin screens.
 * Version: 1.0.0
 * Author: tleen
 * Author URI: http://www.thomasleen.com
 * License: MIT
 */
defined('ABSPATH') or die;


function wp_admin_announce_enqueue_scripts(){
  wp_enqueue_script('jquery');
  wp_enqueue_script('wp-admin-announce.js', plugins_url('wp-admin-announce.js', __FILE__ ), array('jquery'));

  wp_register_style('wp_admin_announce_css', plugins_url('wp-admin-announce.css', __FILE__ ) );
  wp_enqueue_style('wp_admin_announce_css');
}
add_action('admin_enqueue_scripts', 'wp_admin_announce_enqueue_scripts');

function wp_admin_announce_inline(){
  $message = get_option('admin-announce-message-text');
?>
<script type="text/javascript" language="javascript">
/* <![CDATA[ */
      this.adminAnnounce(<?php echo($message ? json_encode($message) : "'Set your message in the Admin Announce plugin settings page.'") ?>);
/* ]]> */
</script>
<?php
}
add_action('in_admin_footer', 'wp_admin_announce_inline');
