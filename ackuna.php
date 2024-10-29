<?php
/*
Plugin Name: Translate
Plugin URI: http://ackuna.com/pages/ackuna
Description: Translator to provide your post content in over 100 languages based on any user's language translation selection. "Translate" by Ackuna.
Version: 4.5.0
Author: Ackuna Translate
Author URI: http://ackuna.com/
License: GPL2
*/

/*
Copyright 2016 Ackuna (email : info@ackuna.com)

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

class AckunaWidget {
	private	$button_path		= '/wp-content/plugins/ackuna-language-translation-plugin';
	private	$javascript_path	= '/javascript';
	private $ackuna_src;
	private	$ackuna_id;
	private	$ackuna_skip_jq;
	private $ackuna_first_save;
	private $ackuna_trial_key;
	private $ackuna_trial_expires;
	private $ackuna_show_branding;
	private $ackuna_languages = array(
		'af' => 'Afrikaans', 
		'sq' => 'Albanian', 
		'am' => 'Amharic', 
		'ar' => 'Arabic', 
		'hy' => 'Armenian', 
		'az' => 'Azerbaijani', 
		'eu' => 'Basque', 
		'be' => 'Belarusian', 
		'bn' => 'Bengali', 
		'bs' => 'Bosnian', 
		'bg' => 'Bulgarian', 
		'ca' => 'Catalan', 
		'ceb' => 'Cebuano', 
		'ny' => 'Chichewa', 
		'zh-CN' => 'Chinese Simplified', 
		'zh-TW' => 'Chinese Traditional', 
		'co' => 'Corsican', 
		'hr' => 'Croatian', 
		'cs' => 'Czech', 
		'da' => 'Danish', 
		'nl' => 'Dutch', 
		'en' => 'English', 
		'eo' => 'Esperanto', 
		'et' => 'Estonian', 
		'tl' => 'Filipino', 
		'fi' => 'Finnish', 
		'fr' => 'French', 
		'fy' => 'Frisian', 
		'gl' => 'Galician', 
		'ka' => 'Georgian', 
		'de' => 'German', 
		'el' => 'Greek', 
		'gu' => 'Gujarati', 
		'ht' => 'Haitian Creole', 
		'ha' => 'Hausa', 
		'haw' => 'Hawaiian', 
		'iw' => 'Hebrew', 
		'hi' => 'Hindi', 
		'hmn' => 'Hmong', 
		'hu' => 'Hungarian', 
		'is' => 'Icelandic', 
		'ig' => 'Igbo', 
		'id' => 'Indonesian', 
		'ga' => 'Irish', 
		'it' => 'Italian', 
		'ja' => 'Japanese', 
		'jw' => 'Javanese', 
		'kn' => 'Kannada', 
		'kk' => 'Kazakh', 
		'km' => 'Khmer', 
		'ko' => 'Korean', 
		'ku' => 'Kurdish', 
		'ky' => 'Kyrgyz', 
		'lo' => 'Lao', 
		'la' => 'Latin', 
		'lv' => 'Latvian', 
		'lt' => 'Lithuanian', 
		'lb' => 'Luxembourgish', 
		'mk' => 'Macedonian', 
		'mg' => 'Malagasy', 
		'ms' => 'Malay', 
		'ml' => 'Malayalam', 
		'mt' => 'Maltese', 
		'mi' => 'Maori', 
		'mr' => 'Marathi', 
		'mn' => 'Mongolian', 
		'my' => 'Myanmar', 
		'ne' => 'Nepali', 
		'no' => 'Norwegian', 
		'ps' => 'Pashto', 
		'fa' => 'Persian', 
		'pl' => 'Polish', 
		'pt' => 'Portuguese', 
		'pa' => 'Punjabi', 
		'ro' => 'Romanian', 
		'ru' => 'Russian', 
		'sm' => 'Samoan', 
		'gd' => 'Scots Gaelic', 
		'sr' => 'Serbian', 
		'st' => 'Sesotho', 
		'sn' => 'Shona', 
		'sd' => 'Sindhi', 
		'si' => 'Sinhala', 
		'sk' => 'Slovak', 
		'sl' => 'Slovenian', 
		'so' => 'Somali', 
		'es' => 'Spanish', 
		'su' => 'Sundanese', 
		'sw' => 'Swahili', 
		'sv' => 'Swedish', 
		'tg' => 'Tajik', 
		'ta' => 'Tamil', 
		'te' => 'Telugu', 
		'th' => 'Thai', 
		'tr' => 'Turkish', 
		'uk' => 'Ukrainian', 
		'ur' => 'Urdu', 
		'uz' => 'Uzbek', 
		'vi' => 'Vietnamese', 
		'cy' => 'Welsh', 
		'xh' => 'Xhosa', 
		'yi' => 'Yiddish', 
		'yo' => 'Yoruba', 
		'zu' => 'Zulu', 
	);
	
	// Constructor.
	function AckunaWidget() {
		// Add the full paths.
		$this->button_path		= plugins_url('ackuna-language-translation-plugin');
		$this->javascript_path	= $this->button_path . $this->javascript_path;
		// Add functions to the content and excerpt.
		add_filter('the_content', array(&$this, 'codeToContent'));
		add_filter('get_the_excerpt', array(&$this, 'ackunaExcerptTrim'));
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'pluginSettingsLink'));
		// Initialize the plugin.
		add_action('admin_menu', array(&$this, '_init'));
		// Display the admin notification
		add_action('admin_notices', array($this, 'plugin_activation'));
		// Get the plugin options.
		$this->ackuna_src = get_option('ackuna_src', 'en');
		$this->ackuna_id = get_option('ackuna_id', null);
		$this->ackuna_skip_jq = get_option('ackuna_skip_jq', false);
		$this->ackuna_first_save = get_option('ackuna_first_save', 0);
		$this->ackuna_trial_key = get_option('ackuna_trial_key', null);
		$this->ackuna_trial_expires = get_option('ackuna_trial_expires', null);
		$this->ackuna_show_branding = get_option('ackuna_show_branding', null);
		// Determine which "ackuna_id" value to use (free trial/registered).
		$ackuna_id_value = !empty($this->ackuna_id) ? (string)$this->ackuna_id : (string)$this->ackuna_trial_key;
		// Parameterize variables for script URL.
		$script_name = sprintf(
			'/e.js?src=%s&conveythis_id=%s&skip_jq=%d', 
			(string)$this->ackuna_src, 
			$ackuna_id_value, 
			(int)$this->ackuna_skip_jq
		);
		// Register our scripts.
		wp_register_script('ackuna_ackuna', $this->javascript_path . $script_name, 'jquery', '4.3.0', true);
		wp_register_script('ackuna_admin_trial_ajax', plugins_url('ackuna-language-translation-plugin') . '/admin-trial-ajax.js', 'jquery', '1.0.0', true);
	}
	
	function _init() {
		// Add the options page.
		add_options_page('Translate Settings', 'Translate', 'manage_options', 'ackuna', array(&$this, 'pluginOptions'));
		add_submenu_page(null, 'Reset Translate Settings', 'Reset Translate', 'manage_options', 'ackuna_reset', array(&$this, 'pluginReset'));
		// Register our plugin settings.
		register_setting('ackuna_options', 'ackuna_src', array(&$this, 'validateLanguage'));
		register_setting('ackuna_options', 'ackuna_id');
		register_setting('ackuna_options', 'ackuna_skip_jq');
		register_setting('ackuna_options', 'ackuna_first_save');
		register_setting('ackuna_options', 'ackuna_trial_key');
		register_setting('ackuna_options', 'ackuna_trial_expires');
		register_setting('ackuna_options', 'ackuna_show_branding');
	}
	
	function plugin_activation() {
		if (current_user_can('manage_options') && !$this->ackuna_first_save) {
			echo <<<EOL
				<div class="error settings-error notice">
					<p><strong>Warning! Your Translate button is not set up yet!</strong></p>
					<p>Be sure to select your site's language and other options under <a href="options-general.php?page=ackuna">Translate Settings</a>!</p>
				</div>
EOL;
		}
	} 
	
	// Print the dropdown, popup code in the footer.
	function ackunaFooter() {
		echo $this->getAckunaDropdown();
		echo $this->getAckunaPopup();
	}
	
	// Called whenever content is shown.
	function codeToContent($content) {
		// What we add depends on type.
		if (is_feed()) {
			// Add nothing to RSS feed.
			return $content;
		} else if (is_category()) {
			// Add nothing to categories.
			return $content;
		} else if (is_singular()) {
			// For singular pages we add the button to the content normally.
			wp_enqueue_script('jquery');
			wp_enqueue_script('ackuna_ackuna');
			add_action('wp_footer', array(&$this, 'ackunaFooter'));
			return $this->getAckunaCode() . $content;
		} else {
            // For everything else add nothing.
            return $content;
        }
	}
	
	// Get the actual button code.
	function getAckunaCode() {
		$ackuna_code = <<<EOL
			<script>var ackuna_plugin_path = "{$this->button_path}";</script>
			<span class="ackuna_image ackuna_drop"></span>
EOL;
		return $ackuna_code;
	}
	
	// Get Ackuna dropdown.
	function getAckunaDropdown() {
		if ($this->ackuna_show_branding || is_null($this->ackuna_show_branding)) {
			$ackuna_dropdown_footer = <<<EOL
				<div class="ackuna-dropdown-footer">
					Get this free button at <a href="http://www.ackuna.com/pages/translate_this?dropdown=y">Ackuna</a><br />
					Powered by <a href="http://www.translation-services-usa.com">Translation Services USA</a>
				</div>
EOL;
		} else {
			$ackuna_dropdown_footer = '';
		}
		$ackuna_dropdown = <<<EOL
			<div id="ackuna-dropdown" class="ackuna-dropdown notranslate" translate="no">
				<div class="ackuna-dropdown-header">
					Select a target language
				</div>
				<div class="ackuna-dropdown-body">
					<ul id="ackuna-dropdown-list" class="ackuna-dropdown-list"></ul>
				</div>
				$ackuna_dropdown_footer
			</div>
EOL;
		return $ackuna_dropdown;
	}
	
	// Get Ackuna popup.
	function getAckunaPopup() {
		if ($this->ackuna_show_branding || is_null($this->ackuna_show_branding)) {
			$ackuna_popup_header_branding	= '<p>Powered by Ackuna</p>';
			$ackuna_popup_body_class		= '';
			$ackuna_popup_footer = <<<EOL
				<div class="ackuna-popup-footer">
					<p><a href="http://www.ackuna.com/pages/translate_this?dropdown=y">Get Your Own Free Translator</a></p>
					<p>Powered by <a href="http://www.translation-services-usa.com">Translation Services USA</a></p>
				</div>
EOL;
		} else {
			$ackuna_popup_header_branding	= '';
			$ackuna_popup_footer			= '';
			$ackuna_popup_body_class		= 'ackuna-unbranded';
		}
		$ackuna_popup = <<<EOL
			<div id="ackuna-popup" class="ackuna-popup notranslate" translate="no">
				<div class="ackuna-popup-dialog">
					<div class="ackuna-popup-content">
						<div class="ackuna-popup-header">
							<button type="button" class="ackuna-close" data-dismiss="ackuna-popup" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<p class="ackuna-popup-title">Translate</p>
							$ackuna_popup_header_branding
						</div>
						<div class="ackuna-popup-body $ackuna_popup_body_class">
							<p>Select a taget language:</p>
							<div id="ackuna-popup-languages"></div>
						</div>
						$ackuna_popup_footer
					</div>
				</div>
			</div>
EOL;
		return $ackuna_popup;
	}
	
	// Reset plugin options.
	function pluginReset() {
		if (!current_user_can('manage_options'))  {
			wp_die('You do not have sufficient permissions to access this page.');
		}
		?>
		<div class="wrap">
			<form method="post" action="options.php">
				<?php settings_fields('ackuna_options'); ?>
				<input name="ackuna_skip_jq" type="hidden" value="0" />
				<input name="ackuna_src" type="hidden" value="en" />
				<input name="ackuna_id" type="hidden" value="" />
				<input name="free_trial" type="hidden" value="0" />
				<input name="ackuna_trial_key" type="hidden" value="" />
				<input name="ackuna_trial_url" type="hidden" value="" />
				<input name="ackuna_trial_expires" type="hidden" value="" />
				<input name="ackuna_first_save" type="hidden" value="0" />
				<input name="ackuna_show_branding" type="hidden" value="0" />
				<h2>Reset Translate Options</h2>
				<p>Click the &quot;Reset Settings&quot; button below to reset the plugin's options to their default settings:</p>
				<table class="widefat">
					<thead>
						<tr>
							<th width="33.333%">Option</th>
							<th width="66.666%">Default Setting</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>jQuery version checking</b></td>
							<td>enabled</td>
						</tr>
						<tr>
							<td><b>Source language</b></td>
							<td>English</td>
						</tr>
						<tr>
							<td><b>Registered ConveyThis account</b></td>
							<td>none</td>
						</tr>
						<tr>
							<td><b>Free trial settings</b></td>
							<td>unset</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" value="Reset Settings to Default" class="button-primary" /> 
								<a href="options-general.php?page=ackuna" class="button">Cancel</a>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<?php
	}
	
	// Admin page display.
	function pluginOptions() {
		if (!current_user_can('manage_options'))  {
			wp_die('You do not have sufficient permissions to access this page.');
		}
		// Enqueue scripts.
		wp_enqueue_script('jquery');
		wp_enqueue_script('ackuna_admin_trial_ajax');
		?>
		<div class="wrap">
			<form id="ackuna-settings" method="post" action="options.php">
				<?php settings_fields('ackuna_options'); ?>
				<input name="ackuna_skip_jq" type="hidden" value="0" />
				<input name="ackuna_src" type="hidden" value="en" />
				<input name="ackuna_id" type="hidden" value="" />
				<input name="free_trial" type="hidden" value="0" />
				<input name="ackuna_trial_key" type="hidden" value="" />
				<input name="ackuna_trial_url" type="hidden" value="" />
				<input name="ackuna_trial_expires" type="hidden" value="" class="ackuna_trial_expires" />
				<input name="ackuna_first_save" type="hidden" value="1" />
				<input name="ackuna_show_branding" type="hidden" value="0" />
				<h2>Translate Settings</h2>
				<p>Update the language and other settings for the Translate plugin.</p>
				<table class="widefat">
					<tbody>
						<tr>
							<td colspan="2"><input type="submit" value="Save Settings" class="button-primary" /></td>
						</tr>
						<tr>
							<td colspan="2" style="padding:10px;font-family:Verdana, Geneva, sans-serif;color:#666;border-bottom:1px dotted #ddd;">
								<p><label for="ackuna_src">Your Site's Current Language</label></p>
								<p>
									<select id="ackuna_src" name="ackuna_src">
										<?php
										$current_src = get_option('ackuna_src') ? get_option('ackuna_src') : $this->ackuna_src;
										asort($this->ackuna_languages);
										foreach ($this->ackuna_languages as $key => &$value) {
											$selected = $current_src == $key ? 'selected="selected"' : '';
											printf('<option %s value="%s">%s</option>', $selected, $key, $value);
										}
										unset($value);
										?>
									</select>
								<p>
								<p>Set this to whatever language your blog is written in. If your blog is in English, and you want visitors to be able to view it in Spanish, Russian, and Japanese, select &quot;English.&quot;</p>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding:10px;font-family:Verdana, Geneva, sans-serif;color:#666;border-bottom:1px dotted #ddd;">
								<p><label for="ackuna_skip_jq"><input id="ackuna_skip_jq" <?php echo $this->ackuna_skip_jq ? 'checked="checked"' : ''; ?> name="ackuna_skip_jq" type="checkbox" value="1" /> Disable jQuery version checking</p>
								<p>Use this only if you are having trouble getting the Translate button to work. This will force-skip jQuery detection by the plugin.</p>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding:10px;font-family:Verdana, Geneva, sans-serif;color:#666;border-bottom:1px dotted #ddd;">
								<p><label for="ackuna_show_branding"><input id="ackuna_show_branding" <?php echo ($this->ackuna_show_branding || is_null($this->ackuna_show_branding)) ? 'checked="checked"' : ''; ?> name="ackuna_show_branding" type="checkbox" value="1" /> Tell somebody about Ackuna :-)</p>
								<p>Translate by Ackuna is not only free to use, it actually costs <i>us</i> money to support! Please help us out by allowing a small backlink to <i>ackuna.com</i> in the button's dropdown/pop-up footer so everyone knows where to get our plugin.</p>
							</td>
						</tr>
						<tr>
							<td <?php echo empty($this->ackuna_id) ? 'width="50%"' : 'colspan="2"'; ?> style="padding:10px;font-family:Verdana, Geneva, sans-serif;color:#666;border-bottom:1px dotted #ddd;">
								<p><label for="ackuna_id">Registered ConveyThis Account Username</label> <input id="ackuna_id" name="ackuna_id" type="text" value="<?php echo htmlspecialchars($this->ackuna_id); ?>" /></p>
								<p>If you have a <a href="http://www.conveythis.com/" target="_blank">registered ConveyThis account</a>, enter your username here to activate your account benefits for your WordPress blog (<b>note:</b> be sure to add your blog URL, &quot;<?php echo bloginfo('url'); ?>&quot; to the approved domains list in your account settings).</p>
								<p>Registered users with a Google Translate API Key can translate their blog text directly on-page without redirecting through a separate frame. Read more at the <a href="http://www.conveythis.com/help.php#8" target="_blank">ConveyThis help</a> page.</p>
							</td>
							<?php
							if (empty($this->ackuna_id)) {
								?>
								<td width="50%" style="padding:10px;font-family:Verdana, Geneva, sans-serif;color:#666;border-bottom:1px dotted #ddd;">
									<?php
									if (empty($this->ackuna_trial_key)) {
										?>
										<p><label for="free_trial"><input id="free_trial" <?php echo (!$this->ackuna_first_save && empty($this->ackuna_trial_key)) ? 'checked="checked"' : ''; ?> name="free_trial" type="checkbox" value="1" /> Try API-powered translation free!</label></p>
										<p>Want to get a feel for how your blog will be translated with a registered ConveyThis account and Google Translate API Key? Just press the checkbox here to start your free trial!</p>
										<?php
									} else {
										?>
										<p>Your free trial information is below. Convinced? <a href="http://www.conveythis.com/" target="_blank">Register on ConveyThis.com!</a></p>
										<?php
									}
									?>
									<p><label for="ackuna_trial_url" style="display:inline-block; min-width:24%">Registered to</label> <input id="ackuna_trial_url" name="ackuna_trial_url" readonly type="text" value="<?php echo bloginfo('url'); ?>" style="min-width:74%;" /></p>
									<p><label for="ackuna_trial_key" style="display:inline-block; min-width:24%">Trial key</label> <input id="ackuna_trial_key" name="ackuna_trial_key" readonly type="text" value="<?php echo $this->ackuna_trial_key; ?>" style="min-width:74%;" /></p>
									<p><label for="ackuna_trial_expires" style="display:inline-block; min-width:24%">Expiration date</label> <input id="ackuna_trial_expires" name="ackuna_trial_expires" readonly type="text" value="<?php echo !empty($this->ackuna_trial_expires) ? date('Y-m-d g:i A T', strtotime($this->ackuna_trial_expires)) : ''; ?>" style="min-width:50%;" class="ackuna_trial_expires" /></p>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<td colspan="2" style="padding:10px;font-family:Verdana, Geneva, sans-serif;color:#666;">
								<b>Note:</b> if you are using any caching plugins, such as WP Super Cache, you will need to clear your cached pages after updating your Translate settings.
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" value="Save Settings" class="button-primary" /> 
								<a href="options-general.php?page=ackuna_reset" class="button">Reset to Default Options</a>
							</td>
						</tr>
					</tbody>
				</table>
				<p><b>Translate</b> is a project by <a href="http://www.ackuna.com/" target="_blank">Ackuna</a>. Get a free app, software, and website translation at Ackuna now!</p>
			</form>
		</div>
		<?php
	}
	
	// Add settings link on plugin page
	function pluginSettingsLink($links) { 
		$settings_link = '<a href="options-general.php?page=ackuna">Settings</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	}
	
	// Remove (what's left of) our button code from excerpts.
	function ackunaExcerptTrim($text) {
		/*
		$pattern		= '/Translatevar ackuna_src = "(.*?)";/i';
		$replacement	= '';
		return preg_replace($pattern, $replacement, $text);
		*/
		return $text;
	}
	
	// Sanitize plugin settings options.
	function validateLanguage($language = null) {
		$return = $this->ackuna_src;
		if (array_key_exists($language, $this->ackuna_languages)) {
			$return = $language;
		}
		return $return;
	}
}

$ackuna &= new AckunaWidget();