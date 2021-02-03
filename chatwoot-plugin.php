<?php
/**
 * Plugin Name:     Chatwoot Plugin
 * Plugin URI:      https://www.chatwoot.com/
 * Description:     Chatwoot Plugin for WordPress
 * Author:          antpb
 * Author URI:      antpb.com
 * Text Domain:     chatwoot-plugin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         chatwoot-plugin
 */

add_action('admin_enqueue_scripts', 'admin_styles');
/**
 * Load Chatwoot Admin CSS.
 *
 * @since 0.1.0
 *
 * @return {void}.
 */
function admin_styles() {
  wp_enqueue_style('admin-styles', plugin_dir_url(__FILE__) . '/admin.css');
}

 add_action( 'wp_enqueue_scripts', 'chatwoot_assets' );
/**
 * Load Chatwoot Assets.
 *
 * @since 0.1.0
 *
 * @return {void}.
 */
function chatwoot_assets() {
    wp_enqueue_script( 'chatwoot-client', plugins_url( '/js/chatwoot.js' , __FILE__ ) );
}

add_action( 'wp_enqueue_scripts', 'chatwoot_load' );
/**
 * Initialize embed code options.
 *
 * @since 0.1.0
 *
 * @return {void}.
 */
function chatwoot_load() {

  // Get our site options for site url and token.
  $chatwoot_url = get_option('chatwootSiteURL');
  $chatwoot_token = get_option('chatwootSiteToken');

  // Localize our variables for the Javascript embed code.
  wp_localize_script( 'chatwoot-client', 'chatwoot_token', $chatwoot_token );
  wp_localize_script( 'chatwoot-client', 'chatwoot_url', $chatwoot_url );
}

add_action('admin_menu', 'chatwoot_setup_menu');
/**
 * Set up Settings options page.
 *
 * @since 0.1.0
 *
 * @return {void}.
 */
function chatwoot_setup_menu(){
    add_options_page('Option', 'Chatwoot Settings', 'manage_options', 'chatwoot-plugin-options', 'chatwoot_options_page');
}

add_action( 'admin_init', 'chatwoot_register_settings' );
/**
 * Register Settings.
 *
 * @since 0.1.0
 *
 * @return {void}.
 */
function chatwoot_register_settings() {
  add_option( 'chatwootSiteToken', '');
  add_option( 'chatwootSiteURL', '');
  register_setting( 'chatwoot-plugin-options', 'chatwootSiteToken', 'myplugin_callback' );
  register_setting( 'chatwoot-plugin-options', 'chatwootSiteURL', 'myplugin_callback' );
}

/**
 * Render page.
 *
 * @since 0.1.0
 *
 * @return {void}.
 */
function chatwoot_options_page() {
  ?>
  <div>
  <?php screen_icon(); ?>
  <h2>Chatwoot Settings</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'chatwoot-plugin-options' ); ?>
  <table>
  <tr valign="top">
  <th scope="row"><label for="chatwootSiteToken">Site Token</label></th>
  <td><input type="text" id="chatwootSiteToken" name="chatwootSiteToken" value="<?php echo get_option('chatwootSiteToken'); ?>" /></td>
  </tr>
  </table>
  <table>
  <tr valign="top">
  <th scope="row"><label for="chatwootSiteToken">ChatWoot URL</label></th>
  <td><input type="text" id="chatwootSiteURL" name="chatwootSiteURL" value="<?php echo get_option('chatwootSiteURL'); ?>" /></td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
}
