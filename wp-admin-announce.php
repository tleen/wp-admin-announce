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

$wp_admin_announce_default_message = 'Set your message in the Admin Announce plugin settings page.';
$wp_admin_announce_colors = array(
  'background' => '#ffff00',
  'border' => '#ff0000',
  'text' => '#000000');

function wp_admin_announce_enqueue_scripts(){

  wp_enqueue_script('jquery');
  wp_enqueue_script('wp-admin-announce.js', plugins_url('wp-admin-announce.js', __FILE__ ), array('jquery'));

  wp_register_style('wp_admin_announce_css', plugins_url('wp-admin-announce.css', __FILE__ ) );
  wp_enqueue_style('wp_admin_announce_css');
}
add_action('admin_enqueue_scripts', 'wp_admin_announce_enqueue_scripts');

function wp_admin_announce_inline(){
  global $wp_admin_announce_default_message, $wp_admin_announce_colors;
  $message = get_option('admin-announce-message-text');
?>
<script type="text/javascript" language="javascript">
/* <![CDATA[ */
  this.adminAnnounce({
    message: <?php echo($message ? json_encode($message) : "'{$wp_admin_announce_default_message}'") ?>,
    colors: {
<?php 
  foreach($wp_admin_announce_colors as $name => $default){ 
    $varName = "admin-announce-{$name}-color";
    $color = get_option($varName);
    if(!$color) $color = $default;
?>
    '<?php echo $name ?>' : '<?php echo $color ?>',
<?php
  }
?>
    }
  });
/* ]]> */
</script>
<?php
}
add_action('in_admin_footer', 'wp_admin_announce_inline');

//* -- Admin Options Execution -- *//

function wp_admin_announce_register_settings(){
  global $wp_admin_announce_colors;

  register_setting('admin-announce-settings-group', 'admin-announce-message-text');

  foreach($wp_admin_announce_colors as $name => $default){
    register_setting('admin-announce-settings-group', "admin-announce-{$name}-color");
  }
}

function wp_admin_announce_plugin_menu() {
  add_menu_page('Admin Announce Plugin Settings', 'Admin Announce', 'administrator', __FILE__, 'wp_admin_announce_settings_page', 'dashicons-megaphone');
  add_action('admin_init', 'wp_admin_announce_register_settings');
}
add_action('admin_menu', 'wp_admin_announce_plugin_menu');

function wp_admin_announce_add_action_links($links){
  $links[] = '<a href="' . admin_url('?page=' . plugin_basename(__FILE__)) . '">Settings</a>';
  return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wp_admin_announce_add_action_links');

function wp_admin_announce_settings_enqueue_scripts(){
  wp_enqueue_script('jquery');
  wp_enqueue_style('wp-color-picker');
  wp_enqueue_script('my-script-handle', plugins_url('wp-admin-announce-settings.js', __FILE__ ), array('jquery', 'wp-color-picker'));
}
add_action('admin_enqueue_scripts', 'wp_admin_announce_settings_enqueue_scripts');

function wp_admin_announce_settings_page(){
  global $wp_admin_announce_default_message, $wp_admin_announce_colors;
?>
<div class="wrap">
  <h2>Admin Announce Settings</h2>
  <form method="post" action="options.php">
<?php settings_fields('admin-announce-settings-group'); ?>
<?php do_settings_sections('admin-announce-settings-group'); ?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row" style="width: 80px">Message:</th>
        <td><input type="text" name="admin-announce-message-text" size="80" placeholder="<?php echo esc_attr($wp_admin_announce_default_message) ?>" value="<?php echo esc_attr(get_option('admin-announce-message-text')) ?>" /></td>
      </tr>
<?php 

  foreach($wp_admin_announce_colors as $name => $default){ 
    $varName = "admin-announce-{$name}-color";
    $current = get_option($varName);
?>
      <tr valign="top">
  <th scope="row" style="width: 130px"><?php echo ucfirst($name) ?> Color:</th>
        <td><input type="text" name="<?php echo $varName ?>" class="admin-announce-color" data-default-color="<?php echo $default ?>" value="<?php echo esc_attr($current ? $current : $default) ?>" /></td>
      </tr>
<?php 
  } 

?>      
    </table>
<?php submit_button(); ?>
  </form>
</div>
<?php  
}