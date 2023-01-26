<?php
/**
 * Plugin Name:     Chatwoot Plugin
 * Plugin URI:      https://www.chatwoot.com/
 * Description:     Chatwoot Plugin for WordPress. This plugin helps you to quickly integrate Chatwoot live-chat widget on Wordpress websites.
 * Author:          antpb
 * Author URI:      chatwoot.com
 * Text Domain:     chatwoot-plugin
 * Version:         0.2.0
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
 * @link https://developer.wordpress.org/reference/functions/wp_localize_script/
 *
 * @since 0.1.0
 *
 * @return {void}.
 */
function chatwoot_load() {

	// Get our site options for site url and token.
	$chatwoot_url             = get_option( 'chatwootSiteURL' );
	$chatwoot_token           = get_option( 'chatwootSiteToken' );
	$chatwoot_widget_locale   = get_option( 'chatwootWidge tLocale' );
	$chatwoot_widget_type     = get_option( 'chatwootWidgetType' );
	$chatwoot_widget_position = get_option( 'chatwootWidgetPosition' );
	$chatwoot_launcher_text   = get_option( 'chatwootLauncherText' );

	// Localize our variables for the Javascript embed code.
  /**
   * 3rd parameter must be an array
   * 
   * @since 0.2.1
   */
	wp_localize_script( 'chatwoot-client', 'chatwoot_token', array( $chatwoot_token ) );
	wp_localize_script( 'chatwoot-client', 'chatwoot_url', array( $chatwoot_url ) );
	wp_localize_script( 'chatwoot-client', 'chatwoot_widget_locale', array( $chatwoot_widget_locale ) );
	wp_localize_script( 'chatwoot-client', 'chatwoot_widget_type', array( $chatwoot_widget_type ) );
	wp_localize_script( 'chatwoot-client', 'chatwoot_launcher_text', array( $chatwoot_launcher_text ) );
	wp_localize_script( 'chatwoot-client', 'chatwoot_widget_position', array( $chatwoot_widget_position ) );
}

add_action( 'admin_menu', 'chatwoot_setup_menu' );
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
  add_option('chatwootSiteToken', '');
  add_option('chatwootSiteURL', '');
  add_option('chatwootWidgetLocale', 'en');
  add_option('chatwootWidgetType', 'standard');
  add_option('chatwootWidgetPosition', 'right');
  add_option('chatwootLauncherText', '');

  register_setting('chatwoot-plugin-options', 'chatwootSiteToken' );
  register_setting('chatwoot-plugin-options', 'chatwootSiteURL');
  register_setting('chatwoot-plugin-options', 'chatwootWidgetLocale' );
  register_setting('chatwoot-plugin-options', 'chatwootWidgetType' );
  register_setting('chatwoot-plugin-options', 'chatwootWidgetPosition' );
  register_setting('chatwoot-plugin-options', 'chatwootLauncherText' );
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
    <h2>Chatwoot Settings</h2>
    <form method="post" action="options.php" class="chatwoot--form">
      <?php settings_fields('chatwoot-plugin-options'); ?>
      <div class="form--input">
        <label for="chatwootSiteToken">Chatwoot Website Token</label>
        <input
          type="text"
          name="chatwootSiteToken"
          value="<?php echo get_option('chatwootSiteToken'); ?>"
        />
      </div>
      <div class="form--input">
        <label for="chatwootSiteURL">Chatwoot Installation URL</label>
        <input
          type="text"
          name="chatwootSiteURL"
          value="<?php echo get_option('chatwootSiteURL'); ?>"
        />
      </div>
      <hr />

      <div class="form--input">
        <label for="chatwootWidgetType">Widget Design</label>
        <select name="chatwootWidgetType">
          <option value="standard" <?php selected(get_option('chatwootWidgetType'), 'standard'); ?>>Standard</option>
          <option value="expanded_bubble" <?php selected(get_option('chatwootWidgetType'), 'expanded_bubble'); ?>>Expanded Bubble</option>
        </select>
      </div>
      <div class="form--input">
        <label for="chatwootWidgetPosition">Widget Position</label>
        <select name="chatwootWidgetPosition">
          <option value="left" <?php selected(get_option('chatwootWidgetPosition'), 'left'); ?>>Left</option>
          <option value="right" <?php selected(get_option('chatwootWidgetPosition'), 'right'); ?>>Right</option>
        </select>
      </div>
      <div class="form--input">
        <label for="chatwootWidgetLocale">Language</label>
        <select name="chatwootWidgetLocale">
          <option <?php selected(get_option('chatwootWidgetLocale'), 'ar'); ?> value="ar">العربية (ar)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'ca'); ?> value="ca">Català (ca)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'cs'); ?> value="cs">čeština (cs)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'da'); ?> value="da">dansk (da)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'de'); ?> value="de">Deutsch (de)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'el'); ?> value="el">ελληνικά (el)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'en'); ?> value="en">English (en)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'es'); ?> value="es">Español (es)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'fa'); ?> value="fa">فارسی (fa)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'fi'); ?> value="fi">suomi, suomen kieli (fi)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'fr'); ?> value="fr">Français (fr)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'hi'); ?> value="hi'">हिन्दी (hi)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'hu'); ?> value="hu">magyar nyelv (hu)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'id'); ?> value="id">Bahasa Indonesia (id)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'it'); ?> value="it">Italiano (it)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'ja'); ?> value="ja">日本語 (ja)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'ko'); ?> value="ko">한국어 (ko)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'ml'); ?> value="ml">മലയാളം (ml)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'nl'); ?> value="nl">Nederlands (nl) </option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'no'); ?> value="no">norsk (no)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'pl'); ?> value="pl">język polski (pl)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'pt_BR'); ?> value="pt_BR">Português Brasileiro (pt-BR)
          <option <?php selected(get_option('chatwootWidgetLocale'), 'pt'); ?> value="pt">Português (pt)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'ro'); ?> value="ro">Română (ro)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'ru'); ?> value="ru">русский (ru)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'sv'); ?> value="sv">Svenska (sv)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'ta'); ?> value="ta">தமிழ் (ta)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'tr'); ?> value="tr">Türkçe (tr)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'vi'); ?> value="vi">Tiếng Việt (vi)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'zh_CN'); ?> value="zh_CN">中文 (zh-CN)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'zh_TW'); ?> value="zh_TW">中文 (台湾) (zh-TW)</option>
          <option <?php selected(get_option('chatwootWidgetLocale'), 'zh'); ?> value="zh'">中文 (zh)</option>
        </select>
      </div>
      <?php if (get_option('chatwootWidgetType') == 'expanded_bubble') : ?>
        <div class="form--input">
          <label for="chatwootLauncherText">Launcher Text (Optional)</label>
          <input
            type="text"
            name="chatwootLauncherText"
            value="<?php echo get_option('chatwootLauncherText'); ?>"
          />
        </div>
      <?php endif; ?>
      <?php submit_button(); ?>
    </form>
  </div>
<?php
}
